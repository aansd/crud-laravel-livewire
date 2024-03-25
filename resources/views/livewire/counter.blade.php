<div class="container">
    @if ($errors->any())
        <div class="pt-3">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $item)
                        <li>{{$item}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @if (session()->has('message'))
        <div class="pt-3">
            <div class="alert alert-success">
                {{session('message')}}
            </div>
        </div>
    @endif

    <!-- START FORM -->
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <form>
            <div class="mb-3 row">
                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" wire:model="nama">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" wire:model="email">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" wire:model="alamat">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                    @if ($updated == false)
                        
                    <button type="button" class="btn btn-primary" name="submit" wire:click="store()">SIMPAN</button>
                    @else
                    <button type="button" class="btn btn-primary" name="submit" wire:click="update()">UPDATE</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
    <!-- AKHIR FORM -->

    <!-- START DATA -->
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h1>Data Pegawai</h1>
        <div class="pb-3 pt-3">
            <input type="text" class="form-control mb-3 w-25" placeholder="search.." wire:model.live="katakunci">
        </div>
        @if ($select_id)
        <a wire:click="delete_confirm('')" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete {{count($select_id)}} Data</a>
            
        @endif

        {{$data->links()}}
        <table class="table table-striped table-sortable">
            <thead>
                <tr>
                    <th></th>
                    <th class="col-md-1">No</th>
                    <th class="col-md-4 sort @if($sortColum == 'nama') {{$sortDrc}} @endif" wire:click="sort('nama')">Nama</th>
                    <th class="col-md-3 sort @if($sortColum == 'email') {{$sortDrc}} @endif" wire:click="sort('email')">Email</th>
                    <th class="col-md-2 sort @if($sortColum == 'alamat') {{$sortDrc}} @endif" wire:click="sort('alamat')">Alamat</th>
                    <th class="col-md-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $item)
                <tr>
                    <td><input type="checkbox" wire:key="{{$item->id}}" value="{{$item->id}}" wire:model.live="select_id"></td>
                    <td>{{$data->firstItem() + $key}}</td>
                    <td>{{$item->nama}}</td>
                    <td>{{$item->email}}</td>
                    <td>{{$item->alamat}}</td>
                    
                    <td>
                        <a wire:click="edit({{$item->id}})" class="btn btn-warning btn-sm">Edit</a>
                        <a wire:click="delete_confirm({{$item->id}})" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$data->links()}}
    </div>
    <!-- AKHIR DATA -->
    <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Confirm Delete</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to delete this data?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary"  data-bs-dismiss="modal" wire:click="delete()">Yes</button>
            </div>
          </div>
        </div>
      </div>
</div>
