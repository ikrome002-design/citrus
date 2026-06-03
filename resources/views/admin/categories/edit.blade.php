@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <h2>Manage Category</h2>
        <div class="text-end mb-3">
            <a href="{{ route('admin.categories.destroy', $category->id) }}"
                data-swal-title="Are you sure you want to delete this business type ? If there are categories and products related to this business type will not deleted"
                class="delete-model btn btn-danger btn-sm me-1"><i class="fa fa-trash"></i> Delete</a>;
        </div>
        @include('layouts.errors-and-messages')
        <div class="card shadow-sm p-4 rounded-lg">
            <ul class="nav nav-tabs mb-3" id="tablist-header" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-category" type="button"
                        role="tab" aria-controls="tab-category" aria-selected="false">Edit Category</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-products" type="button"
                        role="tab" aria-controls="tab-products" aria-selected="false">Products</button>
                </li>
            </ul>

            <div class="tablist-content">
                <div class="tab-pane fade show active" id="tab-category" role="tabpanel" aria-labelledby="tab-category">
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="post" class="form"
                        enctype="multipart/form-data">
                        <div class="row">
                            @csrf
                            @method('patch')
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Category /Sub Category Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" placeholder="Category/ Sub Category Name"
                                        class="form-control" value="{{ $category->name }}">
                                </div>
                                <div class="mb-3">
                                    @if ($category->featured_image)
                                        <img src="/storage/categories/{{ $category->featured_image }}"
                                            class="img-thumbnail img-thumbnail-size">
                                    @endif
                                    <label class="form-label d-block">Featured Image <span
                                            class="text-danger">*</span></label>
                                    <input type="file" name="featured_image" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Is visible (its products visible to customers)</label>
                                    <select name="is_visible" class="form-control select2">
                                        <option @selected($category->is_visible === 'yes') value="yes">Yes</option>
                                        <option @selected($category->is_visible === 'no') value="no">No</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status (add/edit product to category/sub category)</label>
                                    <select name="status" class="form-control select2">
                                        <option @selected($category->status == 'active') value="active">Active</option>
                                        <option @selected($category->status == 'inactive') value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea rows="5" name="description" class="form-control" maxlength="160"
                                        placeholder="small description of maximum of 160 characters SEO purpose">{{ $category->description }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Parent Category if it is sub category (leave if it is main
                                        category)</label>
                                    <select name="parent_id" class="form-control select2">
                                        <option value="">-- Select parent category --</option>
                                        @foreach ($parentCategories as $c)
                                            <option @selected($category->parent_id === $c->id) value="{{ $c->id }}">
                                                {{ $c->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Business Type if main category(leave if it is sub
                                        category)</label>
                                    <select name="business_type_id" class="form-control select2">
                                        <option value="">-- Select business type --</option>
                                        @foreach ($businessTypes as $b)
                                            <option @selected($category->business_type_id == $b->id) value="{{ $b->id }}">
                                                {{ $b->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success mt-4">Save</button>

                    </form>
                </div>
                <div class="tab-pane fade" id="tab-products" role="tabpanel" aria-labelledby="tab-products">...
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection
