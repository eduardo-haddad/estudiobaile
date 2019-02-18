<?php

use Illuminate\Database\Seeder;
use App\PessoaJuridica;
use App\PessoaFisica;

class PlanilhaSeeder extends Seeder
{

    public function xls(){
        $reader = PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(TRUE);
        //arquivo em /public/dados.xlsx
        $spreadsheet = $reader->load(public_path() . '/dados.xlsx');
        return $spreadsheet->getActiveSheet();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        //carrega planilha
        $worksheet = $this->xls();

        //seleciona área
        $data_pf = $worksheet->rangeToArray('H2:H90', NULL, TRUE, FALSE, FALSE);
        $data_pj = $worksheet->rangeToArray('C2:C90', NULL, TRUE, FALSE, FALSE);

        //formata array
        foreach($data_pf as $valor_pf):
            if(!empty($valor_pf[0])) $nomes_pf[] = $valor_pf[0];
            else continue;
        endforeach;
        foreach($data_pj as $valor_pj):
            if(!empty($valor_pj[0])) $nomes_pj[] = $valor_pj[0];
            else continue;
        endforeach;
        $nomes_pf = array_unique($nomes_pf);
        $nomes_pj = array_unique($nomes_pj);

        //PF -- checa duplicados e cria novos registros
        $pessoas_fisicas = PessoaFisica::select('id', 'nome')->orderBy('id')->get();
        $igual = false;
        foreach($nomes_pf as $nome_pf):
            foreach($pessoas_fisicas as $pessoas_fisica):
                if($pessoas_fisica->nome == $nome_pf){
                    $igual = true;
                    break;
                }
            endforeach;

            if(!$igual){
                $nova_pessoa_fisica = new PessoaFisica();
                $nova_pessoa_fisica->nome = $nome_pf;
                $nova_pessoa_fisica->nome_adotado = $nome_pf;
                $nova_pessoa_fisica->estado_civil_id = 6;
                $nova_pessoa_fisica->dt_nascimento = "0000-00-00";
                $nova_pessoa_fisica->criado_por = "Eduardo Haddad";
                $nova_pessoa_fisica->modificado_por = "Eduardo Haddad";
                $nova_pessoa_fisica->save();
            }

            $igual = false;
        endforeach;

        //PJ -- checa duplicados e cria novos registros
        $pessoas_juridicas = PessoaJuridica::select('id', 'nome_fantasia')->orderBy('nome_fantasia')->get();
        $igual = false;
        foreach($nomes_pj as $nome_pj):
            foreach($pessoas_juridicas as $pessoas_juridica):
                if($pessoas_juridica->nome_fantasia == $nome_pj){
                    $igual = true;
                    break;
                }
            endforeach;

            if(!$igual){
                $nova_pessoa_juridica = new PessoaJuridica();
                $nova_pessoa_juridica->nome_fantasia = $nome_pj;
                $nova_pessoa_juridica->razao_social = $nome_pj;
                $nova_pessoa_juridica->criado_por = "Eduardo Haddad";
                $nova_pessoa_juridica->modificado_por = "Eduardo Haddad";
                $nova_pessoa_juridica->save();
            }

            $igual = false;
        endforeach;

    }
}
