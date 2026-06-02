@extends('layouts.master')

@section('title')
    {{ __('manage') . ' ' . __('grade') }}
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                {{ __('manage') . ' ' . __('grade') }}
            </h3>
            <button class="btn btn-theme" data-toggle="modal" data-target="#manageGradeModal">
                <i class="fa fa-plus-circle mr-2"></i> {{ __('Add/Update Grades') }}
            </button>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">
                            {{ __('Grade System List') }}
                        </h4>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('No.') }}</th>
                                        <th>{{ __('Starting Range') }}</th>
                                        <th>{{ __('Ending Range') }}</th>
                                        <th>{{ __('Grade') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($grades as $key => $data)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $data->starting_range }}</td>
                                            <td>{{ $data->ending_range }}</td>
                                            <td>
                                                <span class="badge badge-theme">{{ $data->grade }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">{{ __('No Data Found') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Update Modal -->
    <div class="modal fade" id="manageGradeModal" tabindex="-1" role="dialog" aria-labelledby="manageGradeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="manageGradeModalLabel">{{ __('Manage Grade System') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="create-form" action="{{ route('exam.grade.store') }}" method="POST" data-success-function="formSuccessFunction">
                    <div class="modal-body">
                        <div class="grade-content">
                            <div data-repeater-list="grade_data">
                                <div class="row" data-repeater-item>
                                    <input type="hidden" name="id">
                                    <div class="form-group col-md-4">
                                        <label>{{ __('starting_range') }} </label>
                                        <input type="text" name="starting_range" value="0" class="starting-range form-control" placeholder="{{ __('starting_range') }}" required data-convert="number">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>{{ __('ending_range') }} </label>
                                        <input type="text" name="ending_range" class="ending-range form-control" placeholder="{{ __('ending_range') }}" required max="100" data-convert="number">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>{{ __('grade') }} </label>
                                        <input type="text" name="grades" class="grade form-control" placeholder="{{ __('grade') }}" required>
                                    </div>
                                    <div class="form-group col-md-1 pl-0 mt-4 remove-grades-div" data-repeater-delete>
                                        <button type="button" class="btn btn-icon btn-inverse-danger remove-grades" title="Remove Grade">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 pl-0 mb-4">
                                <button type="button" class="btn btn-success add-grade-content" title="Add new row" data-repeater-create>
                                    {{ __('add_new_data') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                        <input type="submit" class="btn btn-theme" value="{{ __('submit') }}" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var gradesRepeater = $('.grade-content').repeater({
            show: function () {
                $(this).slideDown();
            },
            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });

        $(document).ready(function () {
            @if (isset($grades) && !empty($grades->toArray()))
                gradesRepeater.setList([
                    @foreach ($grades as $data)
                        {
                            id: "{{ $data->id }}",
                            starting_range: "{{ $data->starting_range }}",
                            ending_range: "{{ $data->ending_range }}",
                            grades: "{{ $data->grade }}",
                        },
                    @endforeach
                ]);
            @endif
        });

        function formSuccessFunction() {
            $('#manageGradeModal').modal('hide');
            setTimeout(() => {
                window.location.reload()
            }, 1000);
        }
    </script>
@endsection