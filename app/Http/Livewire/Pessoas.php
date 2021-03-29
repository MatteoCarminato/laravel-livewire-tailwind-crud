<?php

namespace App\Http\Livewire;

use App\Models\Contato;
use App\Models\Pessoa;
use App\Models\TipoContato;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;

class Pessoas extends Component
{
    use WithPagination;

    public $nome, $endereco, $data_nasc, $pessoas, $pessoa_id, $contatos, $tipo_contato;
    public $isOpen = 0;
    public $search;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
        public function render()
    {
        $search = '%%';

        if (strlen($this->search) > 2){
            $search = '%'.$this->search.'%';
        }

        return view('livewire.pessoas',[
            'pessoas_paginate' => Pessoa::where('nome', 'like', $search )->where('user_id',  auth()->user()->id)->orderBy('nome', 'ASC')->paginate(10)
        ]);
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function mount()
    {
        $this->tipo_contato = TipoContato::all();
        $this->contatos = [['nome' => '' , 'valor' => '']];
    }


    public function addContato()
    {
        $this->contatos[] = ['nome' => '', 'valor' => ''];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function openModal()
    {
        $this->isOpen = true;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function closeModal()
    {
        $this->isOpen = false;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function resetInputFields()
    {
        $this->nome = '';
        $this->endereco = '';
        $this->data_nasc = '';
        $this->pessoa_id = '';
        $this->contatos = [['nome' => '', 'valor' => '']];

    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function store()
    {
        $this->validate([
            'nome' => 'required',
            'endereco' => 'required',
            'data_nasc' => 'required',
        ]);

        Contato::where('pessoa_id', $this->pessoa_id)->delete();

        $pessoa = Pessoa::updateOrCreate(['id' => $this->pessoa_id], [
            'nome' => $this->nome,
            'endereco' => $this->endereco,
            'data_nasc' => $this->data_nasc,
            'user_id' =>  auth()->user()->id
        ]);

        foreach ($this->contatos as $value) {
            Contato::create(['tipo_contatos_id' => $value['nome'],
                'valor' => $value['valor'],
                'pessoa_id' => $pessoa->id
            ]);
        }


        session()->flash('message',
            $this->pessoa_id ? 'Usuário atualizado com sucesso.' : 'Usuário cadastrado com sucesso.');

        $this->closeModal();
        $this->resetInputFields();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $pessoa = Pessoa::findOrFail($id);
        $this->pessoa_id = $id;
        $this->nome = $pessoa->nome;
        $this->endereco = $pessoa->endereco;
        $this->data_nasc = $pessoa->data_nasc;

        $contato = Contato::where('pessoa_id', $id)->get();
        $allContato = [];

        foreach ($contato as $value) {
            $allContato[] = ['nome' => $value->tipo_contatos_id, 'valor' => $value->valor];
        }
        $this->contatos = $allContato;

        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Pessoa::find($id)->delete();
        session()->flash('message', 'Pessoa deletada com sucesso.');
        $this->closeModal();
        $this->resetInputFields();
    }

    public function removeContato($index)
    {
        unset($this->contatos[$index]);
    }
}
