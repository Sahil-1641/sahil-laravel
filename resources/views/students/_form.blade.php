@php($isEditing = isset($student))

<form class="card app-card" action="{{ $isEditing ? route('students.update', $student) : route('students.store') }}" method="POST">
    @csrf
    @if ($isEditing)
        @method('PUT')
    @endif
    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <label class="form-label" for="student_number">Student number</label>
                <input class="form-control @error('student_number') is-invalid @enderror" id="student_number" name="student_number" type="text" value="{{ old('student_number', $student->student_number ?? '') }}" maxlength="50" required>
                @error('student_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label" for="name">Full name</label>
                <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" type="text" value="{{ old('name', $student->name ?? '') }}" maxlength="255" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label" for="email">Email address <span class="text-secondary">(optional)</span></label>
                <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email', $student->email ?? '') }}" maxlength="255">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label" for="phone">Phone <span class="text-secondary">(optional)</span></label>
                <input class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" type="tel" value="{{ old('phone', $student->phone ?? '') }}" maxlength="40">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label" for="class_name">Class / grade</label>
                <input class="form-control @error('class_name') is-invalid @enderror" id="class_name" name="class_name" type="text" value="{{ old('class_name', $student->class_name ?? '') }}" maxlength="100" required>
                @error('class_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label" for="date_of_birth">Date of birth <span class="text-secondary">(optional)</span></label>
                <input class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" type="date" value="{{ old('date_of_birth', $student?->date_of_birth?->format('Y-m-d')) }}">
                @error('date_of_birth')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="d-flex flex-wrap gap-2 mt-4">
            <button class="btn btn-primary" type="submit">{{ $isEditing ? 'Save changes' : 'Add student' }}</button>
            <a class="btn btn-outline-secondary" href="{{ $isEditing ? route('students.show', $student) : route('students.index') }}">Cancel</a>
        </div>
    </div>
</form>
