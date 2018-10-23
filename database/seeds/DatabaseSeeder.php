<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Role comes before User seeder here.
        $this->call(RoleTableSeeder::class);
        // User seeder will use the roles above created.
        $this->call(UserTableSeeder::class);
        // Categoria
        $this->call(CategoriaSeeder::class);
        // Cargo
        $this->call(CargoSeeder::class);
        // Genero
        $this->call(GeneroSeeder::class);
        // Estado Civil
        $this->call(EstadoCivilSeeder::class);
        // Endereço
        $this->call(EnderecoSeeder::class);
        //Tipo Conta Bancária
        $this->call(TipoContaBancariaSeeder::class);
        //Dados Bancários
        $this->call(DadoBancarioSeeder::class);
        //Tags
        $this->call(TagSeeder::class);
        // Pessoa Jurídica
        $this->call(PessoaJuridicaSeeder::class);
        // Pessoa Física
        $this->call(PessoaFisicaSeeder::class);
        // Tipo de contato
        $this->call(TipoContatoSeeder::class);
        // Contato
        $this->call(ContatoSeeder::class);
        // Projeto
        $this->call(ProjetoSeeder::class);
        
    }
}
