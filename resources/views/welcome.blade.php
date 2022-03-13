@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card sale-add-items">
                    <div class="card-header">
                        Select Items
                        <button class="btn btn-secoundary btn-sm float-end Show_al_items">Show All</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 row add-categories-area d-flex justify-content-around m-0 p-1">
                                @foreach ($categories as $category )
                                <button class="btn-sm category_btn btn btn-info col-5 mr-1 mb-1 px-0 " data-id="{{$category->id}}">{{$category->name}}</button>
                                @endforeach
                            </div>
                            <div class="col-8 row add-items-area p-0 d-flex justify-content-around m-0 p-1">
                                @foreach ($items as $item)
                                    <button class="btn-sm btn btn-secondary item_btn col-2 m-1 d-none cat_{{$item->category->id}}" data-id="{{$item->category->id}}">{{$item->name}}</button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Add new categories & items
                    </div>
                    <div class="card-body">
                        <form>
                            @csrf
                            <div class="form-group mb-2">
                                <label for="">Categories name</label>
                                <input type="text" class="form-control category_name" name="category_name" placeholder="Enter category">
                            <span class="text-danger error-text category_name_error"></span>
                            </div>
                            <div class="form-group mb-2">
                                <button type="submit" class="btn btn-success form-control add-cat-btn w-md-50">Add Category</button>
                            </div>
                        </form>
                            <hr>
                        <form>
                            @csrf
                            <div class="form-group mb-2">
                                <label for="">Categories name</label>
                                <select name="cat_id" id="" class="form-control select_category">
                                    @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                    <option value="none" selected>select category</option>
                                </select>

                                <span class="text-danger error-text select_name_error"></span>
                            </div>
                            <div class="form-group mb-2">
                                <label for="">Items name</label>
                                <input type="text" class="form-control item_name" name="item_name" placeholder="Enter items">
                                <span class="text-danger error-text item_name_error"></span>
                            </div>
                            <div class="form-group mb-2">
                                <button type="submit" class="btn btn-success form-control add-item-btn">Add item</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{asset('css/welcome.css')}}">
@endpush

@section('script')
<script>
    toastr.options.preventDuplicates = true;
    $.ajaxSetup({
            headers:{
                'X-CSRF-Token':$('meta[name="csrf-token"]').attr('content')
            }
        });
    $("input.category_name").on('input',function (){
        if($(this).val() != " "){
            $('form').find('span.category_name_error').html('');
            $('form').find('.category_name').removeClass('is-invalid');
        };
    })
    $("input.item_name").on('input',function (){
        if($(this).val() != " "){
            $('form').find('span.item_name_error').html('');
            $('form').find('.item_name').removeClass('is-invalid');
        };
    })
    $(".select_category").on('input',function (){
        if($(this).val() != "none"){
            $('form').find('span.select_name_error').html('');
            $('form').find('.select_category').removeClass('is-invalid');
        };
    })
    //Add Categiries
    $(".add-cat-btn").on("click",function(e){
        e.preventDefault();
        var form = $(this).parents('form')[0];
        $.ajax({
            type: "post",
            url: "{{route('add.Category')}}",
            data: new FormData(form),
            processData:false,
            dataType: "json",
            contentType:false,
            beforeSend:function(data){
                if($(form).find('.category_name').val()==''){
                    $(form).find('span.category_name_error').html('input must not be empty!');
                    // $(form).find('.category_name').css("border","1px solid red");
                    $(form).find('.category_name').addClass('is-invalid');
                    data.abort();
                    return ;
                };
            },
            success: function(data) {
                if(data.code == 1){
                    toastr.success(data.cat_name+" add to categories");
                }
                $('body').find('.add-categories-area').prepend('<button class="btn-sm category_btn btn btn-info col-5 mr-1 mb-1 px-0 " data-id="'+data.cat_id+'">'+data.cat_name+'</button>');
                $('body').find('.select_category').prepend(' <option value="'+data.cat_id+'">'+data.cat_name+'</option>');
                $(form).find('.category_name').val('');
                catShow();
            },
        });
    });
    //Add Items
    $(".add-item-btn").on('click',function (e){
        e.preventDefault();
        var form = $(this).parents('form')[0];
        $.ajax({
            type: "post",
            url: "{{route('add.item')}}",
            data: new FormData(form),
            processData:false,
            dataType: "json",
            contentType:false,
            beforeSend:function(data){
                if($(form).find('.item_name').val()=='' && $(form).find('.select_category').val()=='none'){
                    $(form).find('span.item_name_error').html('input must not be empty!');
                    $(form).find('span.select_name_error').html('need one category!');
                    $(form).find('.item_name').addClass('is-invalid');
                    $(form).find('.select_category').addClass('is-invalid');
                    data.abort();
                    return;
                }else if($(form).find('.select_category').val()=='none'){
                    $(form).find('span.select_name_error').html('need one category!');
                    $(form).find('.select_category').addClass('is-invalid');
                    data.abort();
                    return;
                }else if($(form).find('.item_name').val()==''){
                    $(form).find('span.item_name_error').html('input must not be empty!');
                    $(form).find('.item_name').addClass('is-invalid');
                    data.abort();
                    return;
                };
            },
            success: function (data) {
                // alert(data.cat_name);
                console.log(data.cat_name);
                if(data.code == 1){
                    toastr.success(data.item_name+" added!");
                }
                $('body').find('.add-items-area').prepend(' <button class="btn-sm btn btn-secondary col-2 m-1" data-cat_name="'+data.cat_name+'">'+data.item_name+'</button>');
                $(form).find('.item_name').val('');
            }
        });
    })
    //Get Item when click category
    let catShow = ()=>{$('.category_btn').on('click',function(e){
        e.preventDefault();
        var cat_id = $(this).data('id');
        var cat = '.cat_'+cat_id;
        $('.item_btn').addClass('d-none');
        $(`${cat}`).removeClass('d-none');
    })}
    catShow();
    //Get all items
    $('.Show_al_items').on('click',function (e) {
        e.preventDefault();
        $('.item_btn').removeClass('d-none');
    })
</script>
@endsection
