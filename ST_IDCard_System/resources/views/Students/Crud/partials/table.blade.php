 @forelse ($students as $student)
                                    <tr>
                                        {{-- <td>
                                            <input type="checkbox" class="studentCheckbox" value="{{ $student->id }}">
                                        </td> --}}
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($student->image)
                                                <img src="{{ asset('storage/' . $student->image) }}" width="50"
                                                    height="50" class="rounded-circle border shadow-sm"
                                                    alt="Profile Image">
                                            @else
                                                <img src="{{ asset('pos/assets/img/profile.png') }}" width="48"
                                                    class="rounded-circle border shadow-sm" alt="Default Image">
                                            @endif
                                        </td>
                                        <td class="fw-semibold">{{ $student->student_uid }}</td>
                                        <td class="fw-semibold">{{ $student->name }}</td>
                                        <td>{{ $student->father_name }}</td>
                                        <td>{{ $student->mother_name }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->mobile }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $student->gender == 'Male' ? 'primary' : ($student->gender == 'Female' ? 'danger' : 'secondary') }}">
                                                {{ $student->gender }}
                                            </span>
                                        </td>
                                        <td>{{ $student->dob }}</td>
                                        <td>
                                            @if($student->class_name)
                                                <span class="badge bg-info text-dark">
                                                    {{ optional($classes->find($student->class_name))->class_name ?? $student->class_name }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $student->address }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning editBtn me-1"
                                                data-id="{{ $student->id }}" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger deleteBtn"
                                                data-id="{{ $student->id }},{{ $student->name }}" title="Delete">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="13" class="text-center text-muted py-4">
                                            <i class="bi bi-emoji-frown fs-3"></i>
                                            <div>No students found.</div>
                                        </td>
                                    </tr>
                                @endforelse