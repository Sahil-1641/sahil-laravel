@php($isEditing = isset($attendance))

<form class="card app-card" action="{{ $isEditing ? route('attendances.update', $attendance) : route('attendances.store') }}" method="POST">
    @csrf
    @if ($isEditing)
        @method('PUT')
    @endif
    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <label class="form-label" for="student_id">Student</label>
                <select class="form-select @error('student_id') is-invalid @enderror" id="student_id" name="student_id" required>
                    <option value="">Choose a student</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" @selected((string) old('student_id', $attendance->student_id ?? request('student_id', '')) === (string) $student->id)>{{ $student->name }} ({{ $student->student_number }})</option>
                    @endforeach
                </select>
                @error('student_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label" for="date">Date</label>
                <input class="form-control @error('date') is-invalid @enderror" id="date" name="date" type="date" value="{{ old('date', $attendance?->date?->format('Y-m-d') ?? now()->toDateString()) }}" required>
                @error('date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label" for="status">Status</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    @foreach (['present', 'absent', 'late', 'excused'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $attendance->status ?? 'present') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label class="form-label" for="notes">Notes <span class="text-secondary">(optional)</span></label>
                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="4" maxlength="2000">{{ old('notes', $attendance->notes ?? '') }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="d-flex flex-wrap gap-2 mt-4">
            <button class="btn btn-primary" type="submit">{{ $isEditing ? 'Save changes' : 'Save attendance' }}</button>
            <a class="btn btn-outline-secondary" href="{{ $isEditing ? route('attendances.show', $attendance) : route('attendances.index') }}">Cancel</a>
        </div>
    </div>
</form>
