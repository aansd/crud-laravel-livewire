<?php

namespace App\Livewire;

use App\Models\Counter as ModelsCounter;
use Livewire\Component;
use Livewire\WithPagination;

class Counter extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $nama;
    public $email;
    public $alamat;
    public $updated = false;
    public $data_id;
    public $katakunci;
    public $select_id = [];
    public $sortColum = 'nama';
    public $sortDrc = 'asc';




    public function store()
    {
        $rules = [
            'nama' => 'required',
            'email' => 'required|email',
            'alamat' => 'required'
        ];

        $pesan = [
            'nama.required' => 'nama wajib di isi',
            'email.required' => 'email wajib di isi',
            'email.email' => 'Format email tidak sesuai',
            'alamat.required' => 'alamat wajib di isi'
        ];

        $validated = $this->validate($rules, $pesan);
        ModelsCounter::create($validated);
        session()->flash('message', 'Data behasil di tambahkan');


        $this->clear();
    }

    public function edit($id)
    {
        $data = ModelsCounter::find($id);
        $this->nama = $data->nama;
        $this->email = $data->email;
        $this->alamat = $data->alamat;

        $this->updated = true;
        $this->data_id = $id;
    }

    public function update()
    {
        $rules = [
            'nama' => 'required',
            'email' => 'required|email',
            'alamat' => 'required'
        ];

        $pesan = [
            'nama.required' => 'nama wajib di isi',
            'email.required' => 'email wajib di isi',
            'email.email' => 'Format email tidak sesuai',
            'alamat.required' => 'alamat wajib di isi'
        ];

        $validated = $this->validate($rules, $pesan);
        $data = ModelsCounter::find($this->data_id);
        $data->update($validated);
        session()->flash('message', 'Update behasil');

        $this->clear();
    }

    public function clear()
    {
        $this->nama = '';
        $this->email = '';
        $this->alamat = '';

        $this->updated = false;
        $this->data_id = '';
        $this->select_id = [];
    }

    public function delete()
    {
        if ($this->data_id = ''){
            $id = $this->data_id;
            ModelsCounter::find($id)->delete();
        }
        
        if (count($this->select_id)) {
            for($x=0; $x < count($this->select_id); $x++){
                ModelsCounter::find($this->select_id[$x])->delete();
            }
        }
        session()->flash('meesage', 'Data berhasil di delete');
        $this->clear();
    }

    public function delete_confirm($id)
    {
        if ($id != ''){
            $this->data_id = $id;
        }
    }

    public function sort($columName)
    {
        $this->sortColum = $columName;
        $this->sortDrc = $this->sortDrc == 'asc' ? 'desc' : 'asc';
    }


    public function render()
    {
        if ($this->katakunci != null) {
            $data = ModelsCounter::where('nama', 'like', '%' . $this->katakunci . '%')
            ->orWhere('email', 'like', '%' . $this->katakunci . '%')
            ->orWhere('alamat', 'like', '%' . $this->katakunci . '%')
            ->orderBy($this->sortColum, $this->sortDrc)->paginate(2);
        } else {
            $data = ModelsCounter::orderBy($this->sortColum, $this->sortDrc)->paginate(2);
        }
        return view('livewire.counter', ['data' => $data]);
    }
}
