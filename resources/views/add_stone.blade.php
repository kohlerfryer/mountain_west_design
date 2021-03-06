@extends('layouts.admin')

@section('content')


    <section class="content add_stone_section" id="add_stone_section">
      <h1>
        Add Stone To Inventory
      </h1>
    </br>
     <form id="add_stone_form">
       Stone Name</br>
       <input name="stone_name" id="stone_name"></br></br>
       Stone Type </br>
       <select name="stone_type" id="stone_type" style="width:150px">
          <option value="">select type</option>
          @foreach($stone_types as $stone_type)
             <option value="{{trim($stone_type->type)}}" >{{$stone_type->type}}</option>
          @endforeach
       </select></br></br>
       Price Per Square Foot</br>
       <input name="stone_price" id="stone_price"></br></br>
       Group</br>
       <select name="group" id="stone_group" style="width:150px">
          <option value="">select type</option>
          @foreach($stone_groups as $stone_group)
             <option value="{{trim($stone_group->id)}}" >{{$stone_group->name}}</option>
          @endforeach
       </select></br></br>
       In Stock Quantity</br>
       <input name="stone_quantity" id="stone_quantity"></br></br>
       Stone Description</br>
       <textarea name="stone_description" id="stone_description" style="width:400px;height:100px"></textarea></br></br>
       Stone Image
       <input type="file" name="stone_image" id="stone_image" enctype='multipart/form-data'></br>
       Stone Texture
       <input type="file" name="stone_texture" id="stone_texture" enctype='multipart/form-data'></br>
       <input type="hidden" name="_token" value="{{ csrf_token() }}">
       <button type="submit">Submit</button>
     </form>
    </section>

  @endsection



