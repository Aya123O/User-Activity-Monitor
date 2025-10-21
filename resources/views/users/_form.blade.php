<div class="mb-3">
    <label for="name" class="form-label">Name *</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email *</label>
    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@if(!isset($user) || !$user->id)
<div class="mb-3">
    <label for="password" class="form-label">Password *</label>
    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
    @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="password_confirmation" class="form-label">Confirm Password *</label>
    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
</div>
@endif

<div class="mb-3">
    <label for="role" class="form-label">Role *</label>
    <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
        <option value="user" {{ (old('role', $user->role ?? '') == 'user') ? 'selected' : '' }}>User</option>
        <option value="admin" {{ (old('role', $user->role ?? '') == 'admin') ? 'selected' : '' }}>Admin</option>
    </select>
    @error('role')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="avatar" class="form-label">Profile Picture</label>
    <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar" accept="image/*">
    @error('avatar')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    @if(isset($user) && $user->avatar)
        <div class="mt-2">
            <img src="{{ Storage::disk('public')->url($user->avatar) }}" alt="Avatar" class="img-thumbnail" width="100">
        </div>
    @endif
</div>

@if(isset($user) && $user->id)
<div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" 
           {{ (old('is_active', $user->is_active ?? true)) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Active User</label>
</div>
@endif