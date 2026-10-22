@php($isEditing = isset($project))

<form class="service-card" action="{{ $isEditing ? route('projects.update', $project) : route('projects.store') }}" method="POST">
    @csrf
    @if ($isEditing)
        @method('PUT')
    @endif

    <div class="w-100">
        <label class="form-label" for="name">Project name</label>
        <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" type="text" value="{{ old('name', $project->name ?? '') }}" maxlength="255" required>
        @error('name')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="w-100">
        <label class="form-label" for="location">Location</label>
        <input class="form-control @error('location') is-invalid @enderror" id="location" name="location" type="text" value="{{ old('location', $project->location ?? '') }}" maxlength="255" required>
        @error('location')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="w-100">
        <label class="form-label" for="description">Description</label>
        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description', $project->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex flex-wrap align-items-center gap-3">
        <button class="button button-primary border-0" type="submit">{{ $isEditing ? 'Update project' : 'Save project' }}</button>
        <a class="text-link" href="{{ $isEditing ? route('projects.show', $project) : route('projects.index') }}">Cancel</a>
    </div>
</form>