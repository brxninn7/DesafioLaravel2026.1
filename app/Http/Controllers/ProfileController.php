<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'addresses' => $request->user()->addresses ?? collect()
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'cpf' => 'nullable|string|max:14|unique:users,cpf,' . $user->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user->fill($request->only(['name', 'email', 'phone', 'date_of_birth', 'cpf']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $request->file('photo')->store('profile_photos', 'public');
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function storeAddress(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'cep' => 'required|string|max:9',
            'logradouro' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'bairro' => 'required|string|max:105',
            'cidade' => 'required|string|max:105',
            'estado' => 'required|string|max:2',
            'complemento' => 'nullable|string|max:255',
        ]);

        $addressData = $validated;
        if (isset($addressData['estado'])) {
            $addressData['estato'] = $addressData['estado'];
            unset($addressData['estado']);
        }

        $request->user()->addresses()->create($addressData);

        return back()->with('success', 'Endereço adicionado com sucesso!');
    }

    public function destroyAddress(Address $address): RedirectResponse
    {
        if (auth()->id() !== $address->user_id) {
            abort(403);
        }

        $address->delete();

        return back()->with('success', 'Endereço removido!');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'value' => 'required|numeric|min:1',
        ]);

        $user = auth()->user();
        
        $user->saldo += $request->value;
        $user->save();

        return back()->with('success', 'Saldo adicionado com sucesso!');
    }
}