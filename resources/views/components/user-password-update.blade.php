<div>
    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <form method="POST" action="{{ route('profile.password.update') }}">
        @csrf
        <div class="form-group">
            <label for="password">Contraseña actual</label>
            <input type="password" class="form-control" id="password" name="password">
            @error('currentPassword') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="newPassword">Nueva contraseña</label>
            <input type="password" class="form-control" id="newPassword" name="newPassword">
            @error('newPassword') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="confirmPassword">Confirmar nueva contraseña</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
            @error('confirmPassword') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Actualizar contraseña</button>
    </form>
</div>
