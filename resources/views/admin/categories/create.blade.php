@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('layouts.errors-and-messages')
        <div class="card shadow-sm p-4 rounded-lg create-caregories-box">
            <form action="{{ route('admin.categories.store') }}" method="post" class="form" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Category /Sub Category Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" placeholder="Category/ Sub Category Name"
                                class="form-control" value="{{ old('name') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Featured Image <span class="text-danger">*</span></label>
                            <input type="file" name="featured_image" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Is visible to customers</label>
                            <select name="is_visible" class="form-control select2">
                                <option selected value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status (add/edit product to category/sub category)</label>
                            <select name="status" class="form-control select2">
                                <option selected value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Description</span></label>
                            <textarea rows="5" class="form-control" name="description" maxlength="160"
                                placeholder="small description of maximum of 160 characters SEO purpose"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Parent Category if it is sub category (leave if it is main
                                category)</label>
                            <select name="parent_id" class="form-control select2">
                                <option value="">-- Select parent category --</option>
                                @foreach ($parentCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Business Type if main category(leave if it is sub category)</label>
                            <select name="business_type_id" class="form-control select2">
                                <option value="">-- Select business type --</option>
                                @foreach ($businessTypes as $b)
                                    <option value="{{ $b->id }}">{{ $b->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>


                <button type="submit" class="btn btn-success mt-4">Add Category</button>

            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
