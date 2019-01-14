<template v-if="this.pessoa">

    <div id="container_conteudo" class="formulario" :class="{ loading: !item_carregado, loaded: item_carregado }">

        <modal v-if="modalDelete" @close="modalDelete = false">
            <h3 slot="header">Excluir registro?</h3>
        </modal>

        <editbar></editbar>

        <div class="titulo">
            <div v-if="destaqueAtivo" class="imagem_destaque">
                <a :href="imagem_destaque_original" data-lightbox="imagem_destaque" :data-title="pessoa.nome_adotado">
                    <img :src="imagem_destaque" />
                </a>
            </div>
            <div v-else class="imagem_destaque">
                <img :src="imagem_destaque" />
            </div>
            <div class="nome">
                <span>
                    <!--<input autocomplete="off" type="text" placeholder=" "-->
                             <!--v-model="pessoa.nome_adotado"-->
                             <!--name="nome_adotado" style="border:none" />-->
                    {{ pessoa.nome_adotado }}
                </span>
            </div>
        </div>
        <br>
        <br>
        <br>

        <!-- Tags -->
        <span class="campo" style="float: left;">Tags</span>
        <select @change="tags_atuais = $event.target.value" name="tags" id="tags_list" class="js-example-basic-single">
            <option v-for="tag in tags" :value="tag.id" v-model="tag.id"><a href="#">{{ tag.text }}</a></option>
        </select>


        <hr>

        <!-- Arquivos -->
        <div class="valor" style="margin-top: 3px;">
            <span class="titulo_bloco">Arquivos anexos</span>
            <br>
            <input type="file" class="inputfile" id="arquivo" ref="arquivo" @change="setArquivoAtual" />
            <label for="arquivo">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                </svg>
                <span v-text="typeof arquivo_atual.name !== 'undefined' ? arquivo_atual.name.trunc(30) : 'Selecione um arquivo'" v-model="arquivo_atual.name"></span>
            </label>&nbsp;&nbsp;
            <input type="text" @input="descricao_arquivo = $event.target.value" name="descricao_arquivo" v-model="descricao_arquivo" placeholder="Descrição" autocomplete="off" style="width: 200px; min-width: unset; margin-right: 10px;" />
            <button @click.prevent="upload">Submit</button>
            <br><br>
            <div class="tabela_arquivos">
                <table>
                    <tr>
                        <th class="num_arquivo">#</th>
                        <th class="nome_arquivo">Nome</th>
                        <th class="descricao_arquivo">Descrição</th>
                        <th class="preview_arquivo">Visualizar</th>
                        <th class="destaque_arquivo">Destaque</th>
                        <th class="tipo_arquivo">Tipo</th>
                        <th class="data_arquivo">Data</th>
                        <th class="remove_arquivo">Remover</th>
                    </tr>
                    <tr v-for="(arquivo, index) in arquivos" :key="'arquivo-'+index + arquivo.id">
                        <td class="num_arquivo">{{ index+1 }}</td>
                        <td class="nome_arquivo"><a :title="arquivo.nome.substr(15)" :href="`/download/pf/${pessoa.id}/${arquivo.id}`" download>{{ arquivo.nome.substr(15).trunc(30) }}</a></td>
                        <td class="descricao_arquivo">
                            <input autocomplete="off" type="text" placeholder=" " name="arquivo_descricao" v-model="arquivo.descricao" />
                        </td>
                        <td class="preview_arquivo">
                            <a v-if="arquivo.tipo === 'imagem'"
                               :href="`/uploads/pessoas_fisicas/${pessoa.id}/${arquivo.nome}`"
                               :data-lightbox="'imagem_preview'+index" :data-title="arquivo.nome.substr(15)">
                                <img class="btn_preview"
                                     :src="root + '/img/btn_preview.png'" />
                            </a>
                        </td>
                        <td class="destaque_arquivo">
                            <a @click.prevent="setImagemDestaque(arquivo.id)">
                                <img v-if="arquivo.tipo === 'imagem'"
                                     class="btn_destaque"
                                     :src="id_destaque === arquivo.id ? root + '/img/btn_destaque_ativo.png' : root + '/img/btn_destaque.png'" />
                            </a>
                        </td>
                        <td class="tipo_arquivo">{{ arquivo.tipo }}</td>
                        <td class="data_arquivo">{{ arquivo.data }}</td>
                        <td class="remove_arquivo"><a @click.prevent="removeArquivo(arquivo.id)">X</a></td>
                    </tr>
                </table>
            </div>
        </div>

        <br><hr>

        <!--DADOS GERAIS-->
        <span class="titulo_bloco">Dados gerais</span>

        <div class="dados">

            <div class="valor">
                <span class="campo">Nome</span>
                <input autocomplete="off" type="text" placeholder=" "
                       v-model="pessoa.nome"
                       name="nome"
                />
            </div><br>

            <div class="valor">
                <span class="campo">Nome adotado</span>
                <input autocomplete="off" type="text" placeholder=" "
                       v-model="pessoa.nome_adotado"
                       name="nome_adotado"
                />
            </div><br>

            <div class="valor">
                <span class="campo">Gênero</span>
                <!--<select name="genero" v-model="pessoa.genero_id">-->
                    <!--<option v-for="(genero, index) in atributos.generos" :value="genero.id" :key="'genero-'+index + genero.id">-->
                        <!--{{ genero.valor == 'F' ? 'Feminino' : 'Masculino' }}-->
                    <!--</option>-->
                <!--</select>-->
                <the-mask
                        :mask="['Aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa']"
                        class="mask-input genero"
                        v-model="pessoa.genero"
                        type="text"
                        autocomplete="off"
                        name="pessoa.genero"
                        placeholder=" " />
            </div><br>

            <div class="valor">
                <span class="campo">Estado civil</span>
                <select name="estado_civil" v-model="pessoa.estado_civil_id">
                    <option v-for="(estado_civil, index) in atributos.estados_civis" :value="estado_civil.id" :key="'estado_civil-'+index + estado_civil.id">
                        {{ estado_civil.valor }}
                    </option>
                </select>
            </div><br>

            <div class="valor">
                <span class="campo">Data de Nasc.</span>
                <input
                        type="text"
                        v-model="nova_dt_nascimento"
                        name="dt_nascimento"
                        placeholder=" "
                        onkeyup="
                            var v = this.value;
                            if (v.match(/^\d{2}$/) !== null) {
                                this.value = v + '/';
                            } else if (v.match(/^\d{2}\/\d{2}$/) !== null) {
                                this.value = v + '/';
                            }"
                        maxlength="10"
                        @input="formataDataNascimento($event.target.value)">
            </div><br>

            <div class="valor">
                <span class="campo">Nacionalidade</span>
                <input autocomplete="off" type="text" placeholder=" "
                       v-model="pessoa.nacionalidade"
                       name="nacionalidade"
                />
            </div><br>

            <div class="valor">
                <span class="campo">Naturalidade</span>
                <input autocomplete="off" type="text" placeholder=" "
                       v-model="pessoa.naturalidade"
                       name="naturalidade"
                />
            </div><br>

            <!-- DOCUMENTOS -->
            <div class="valor">
                <span class="campo">RG</span>
                <the-mask
                        :mask="['XX.XXX.XXX-X']"
                        class="mask-input cpf"
                        v-model="pessoa.rg"
                        type="text"
                        autocomplete="off"
                        name="rg"
                        placeholder=" " />
            </div><br>

            <div class="valor">
                <span class="campo">CPF</span>
                <the-mask
                        :mask="['###.###.###-##']"
                        class="mask-input cpf"
                        v-model="pessoa.cpf"
                        type="text"
                        autocomplete="off"
                        name="cpf"
                        placeholder=" " />
            </div><br>

            <div class="valor">
                <span class="campo">Passaporte</span>
                <input autocomplete="off" type="text" placeholder=" "
                       v-model="pessoa.passaporte"
                       name="passaporte"
                />
            </div><br>

            <br>
            <label><input type="checkbox" @click="mostraMei = !mostraMei" :checked="mostraMei" style="margin-right: 10px" />Possui MEI</label>
            <div v-if="mostraMei" style="margin-top: 15px">
                <div class="valor">
                    <span class="campo">CNPJ</span>
                    <input autocomplete="off" type="text" placeholder=" "
                           v-model="pessoa.cnpj"
                           name="cnpj"
                    />
                </div><br>

                <div class="valor">
                    <span class="campo">Razão Social</span>
                    <input autocomplete="off" type="text" placeholder=" "
                           v-model="pessoa.razao_social"
                           name="razao_social"
                    />
                </div>

                <div class="valor">
                    <span class="campo">Website</span>
                    <input autocomplete="off" type="text" placeholder=" "
                           v-model="pessoa.website"
                           name="website"
                    />
                </div><br>
            </div>

            <hr>

            <!-- Pessoas Jurídicas Relacionadas -->
            <span class="titulo_bloco">Pessoas Jurídicas Relacionadas</span>

            <div id="projetos_pf" class="valor">
                <div id="chancelas" class="cargos">
                    <div class="tabela_arquivos">
                        <table>
                            <tr>
                                <th class="num_arquivo">#</th>
                                <th class="nome_arquivo">Nome</th>
                                <th class="descricao_arquivo">Cargo</th>
                                <th class="destaque_arquivo"></th>
                                <th class="tipo_arquivo"></th>
                                <th class="data_arquivo"></th>
                                <th class="remove_arquivo">Remover</th>
                            </tr>
                            <tr v-for="(pessoa, index) in pessoas_juridicas_relacionadas" :key="'pj-'+index + pessoa.pessoa_juridica_id">
                                <td class="num_arquivo">{{ index+1 }}</td>
                                <td class="nome_arquivo"><router-link :id="pessoa.pessoa_juridica_id" :to="{ name: 'pj-view',
                                params: { id: pessoa.pessoa_juridica_id }}">{{ pessoa.nome_fantasia.trunc(30) }}</router-link></td>
                                <td class="descricao_arquivo">{{ pessoa.cargo }}</td>
                                <td class="destaque_arquivo"></td>
                                <td class="tipo_arquivo"></td>
                                <td class="data_arquivo"></td>
                                <td class="remove_arquivo"><a @click.prevent="removeChancelaPj(pessoa.pessoa_juridica_id, pessoa.cargo_id)">X</a></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div><br>

            <!-- Add novo chancela pessoa jurídica -->
            <a @click="mostraChancelaPjBoxMetodo" class="link_abrir_box">[adicionar pessoa jurídica]</a>
            <div v-if="mostraChancelaPjBox">
                <!--novo_cargo-->
                <span class="campo">Nome</span>
                <select @change="" name="pessoas_juridicas" class="pj_lista">
                    <option disabled selected value> -- Selecione um nome -- </option>
                    <option v-for="pessoa in atributos.pessoas_juridicas" :value="pessoa.id">
                        {{ pessoa.nome_fantasia }}
                    </option>
                </select><br>
                <span class="campo">Chancela</span>
                <select @change="" name="chancelas" class="chancelas_pj_lista">
                    <option disabled selected value> -- Selecione uma chancela -- </option>
                    <option v-for="chancela in atributos.chancelas_pj" :value="chancela.id">{{ chancela.valor }}</option>
                </select>
                <a @click.prevent="adicionaChancelaPj">[+]</a>

            </div>

            <br>

            <hr>

            <!-- Emails -->
            <span class="titulo_bloco">E-mails</span>
            <div>
                <div v-for="(email, index) in emails" class="valor" :key="'email-'+index + email.id">
                    <span class="campo">E-mail {{ index+1 }}</span>
                    <input autocomplete="off" type="text" placeholder=" " :id="email.id" v-model="email.valor" name="email" />
                    <a @click.prevent="removeContato(email.id)">X</a>
                </div>
                <br>
                <a @click.prevent="adicionaEmail = !adicionaEmail" class="link_abrir_box">[adicionar email]</a>
                <div v-if="adicionaEmail" class="adiciona_contato">
                    <input @input="novo_email = $event.target.value" type="text" class="adiciona_contato" v-model="novo_email" name="novo_email" autocomplete="off" placeholder="adicionar email" />
                    <a @click.prevent="adicionaContato()">+</a>
                </div>
            </div>

            <hr>

            <!-- Telefones -->
            <span class="titulo_bloco">Telefones</span>

            <div>
                <div v-for="(telefone, index) in telefones" class="valor" :key="'telefone-'+index + telefone.id">
                    <span class="campo">Telefone</span>
                    <input type="text" placeholder=" " :id="telefone.id" v-model="telefone.valor" name="telefone" autocomplete="off" />
                    <a @click.prevent="removeContato(telefone.id)">X</a>
                </div>
                <br>
                <a @click.prevent="adicionaTel = !adicionaTel" class="link_abrir_box">[adicionar telefone]</a>
                <div v-if="adicionaTel" class="adiciona_contato">
                    <input @input="novo_telefone = $event.target.value" type="text" class="adiciona_contato" v-model="novo_telefone" name="novo_telefone" placeholder="adicionar telefone" autocomplete="off" />
                    <a @click.prevent="adicionaContato()">+</a>
                </div>

            </div>

            <hr>

            <!-- Participação no(s) projeto(s) Estúdio Baile -->
            <span class="titulo_bloco">Participação no(s) projeto(s) Estúdio Baile</span>

            <div id="projetos">
                <div class="tabela_arquivos">
                    <table>
                        <tr>
                            <th class="num_arquivo">#</th>
                            <th class="nome_arquivo">Projeto</th>
                            <th class="descricao_arquivo">Chancela</th>
                            <th class="destaque_arquivo"></th>
                            <th class="tipo_arquivo"></th>
                            <th class="data_arquivo"></th>
                            <th class="remove_arquivo">Remover</th>
                        </tr>
                        <tr v-for="(projeto, index) in projetos" :key="'projeto-'+index + projeto.id">
                            <td class="num_arquivo">{{ index+1 }}</td>
                            <td class="nome_arquivo"><router-link :id="projeto.id" :to="{ name: 'projetos-view', params: { id: projeto.id }}">{{ projeto['projeto'] }}</router-link></td>
                            <td class="descricao_arquivo">{{ projeto['chancela'] }}</td>
                            <td class="destaque_arquivo"></td>
                            <td class="tipo_arquivo"></td>
                            <td class="data_arquivo"></td>
                            <td class="remove_arquivo"><a @click.prevent="console.log('remover')">X</a></td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr>

            <!-- Endereços -->
            <span class="titulo_bloco">Endereços</span>

            <div v-for="(endereco, index) in enderecos" :key="'endereco-'+index + endereco.id" class="form_endereco">

                <span class="titulo_bloco"># {{index+1}}:</span> <a @click="removeEndereco(endereco.id)">X</a> <br>
                <div class="valor">
                    <span class="campo">Logradouro</span>
                    <input autocomplete="off" type="text" placeholder=" " name="endereco.rua" v-model="endereco.rua" />
                </div><br>
                <div class="valor">
                    <span class="campo">Número</span>
                    <the-mask
                            :mask="['######']"
                            class="mask-input numero"
                            v-model="endereco.numero"
                            type="text"
                            autocomplete="off"
                            name="endereco.numero"
                            placeholder=" " />
                </div><br>
                <div class="valor">
                    <span class="campo">Complemento</span>
                    <input autocomplete="off" type="text" placeholder=" " name="endereco.complemento" v-model="endereco.complemento" />
                </div><br>
                <div class="valor">
                    <span class="campo">Bairro</span>
                    <input autocomplete="off" type="text" placeholder=" " name="endereco.bairro" v-model="endereco.bairro" />
                </div><br>
                <div class="valor">
                    <span class="campo">cep</span>
                    <the-mask
                            :mask="['#####-###']"
                            class="mask-input cep"
                            v-model="endereco.cep"
                            type="text"
                            autocomplete="off"
                            name="endereco.cep"
                            placeholder=" " />
                </div><br>
                <div class="valor">
                    <span class="campo">cidade</span>
                    <input autocomplete="off" type="text" placeholder=" " name="endereco.cidade" v-model="endereco.cidade" />
                </div><br>
                <div class="valor">
                    <span class="campo">uf</span>
                    <the-mask
                            :mask="['AA']"
                            class="mask-input uf"
                            v-model="endereco.estado"
                            type="text"
                            autocomplete="off"
                            name="endereco.estado"
                            placeholder=" " />
                </div><br>
                <div class="valor">
                    <span class="campo">País</span>
                    <input autocomplete="off" type="text" placeholder=" " name="endereco.pais" v-model="endereco.pais" />
                </div><br>
            </div>

            <!--Add novo endereço-->
            <a @click="mostraEnderecoBox = !mostraEnderecoBox" class="link_abrir_box">[adicionar endereço]</a>
            <div v-if="mostraEnderecoBox">
                <span class="campo">--- Novo Endereço</span><br>
                <div class="valor">
                    <span class="campo">Logradouro</span>
                    <input @input="novo_endereco.rua = $event.target.value" autocomplete="off" type="text" placeholder=" " name="novo_endereco.rua" v-model="novo_endereco.rua" />
                </div><br>
                <div class="valor">
                    <span class="campo">Número</span>
                    <the-mask
                            :mask="['######']"
                            @input="novo_endereco.numero = $event.target.value"
                            class="mask-input numero"
                            v-model="novo_endereco.numero"
                            type="text"
                            autocomplete="off"
                            name="novo_endereco.numero"
                            placeholder=" " />
                </div><br>
                <div class="valor">
                    <span class="campo">Complemento</span>
                    <input @input="novo_endereco.complemento = $event.target.value" autocomplete="off" type="text" placeholder=" " name="novo_endereco.complemento" v-model="novo_endereco.complemento" />
                </div><br>
                <div class="valor">
                    <span class="campo">Bairro</span>
                    <input @input="novo_endereco.bairro = $event.target.value" autocomplete="off" type="text" placeholder=" " name="novo_endereco.bairro" v-model="novo_endereco.bairro" />
                </div><br>
                <div class="valor">
                    <span class="campo">cep</span>
                    <the-mask
                            :mask="['#####-###']"
                            @input="novo_endereco.cep = $event.target.value"
                            class="mask-input cep"
                            v-model="novo_endereco.cep"
                            type="text"
                            autocomplete="off"
                            name="novo_endereco.cep"
                            placeholder=" " />
                </div><br>
                <div class="valor">
                    <span class="campo">cidade</span>
                    <input @input="novo_endereco.cidade = $event.target.value" autocomplete="off" type="text" placeholder=" " name="novo_endereco.cidade" v-model="novo_endereco.cidade" />
                </div><br>
                <div class="valor">
                    <span class="campo">uf</span>
                     <the-mask
                            :mask="['AA']"
                            @input="novo_endereco.estado = $event.target.value"
                            class="mask-input uf"
                            v-model="novo_endereco.estado"
                            type="text"
                            autocomplete="off"
                            name="novo_endereco.estado"
                            placeholder=" " />
                </div><br>
                <div class="valor">
                    <span class="campo">País</span>
                    <input @input="novo_endereco.pais = $event.target.value" autocomplete="off" type="text" placeholder=" " name="novo_endereco.pais" v-model="novo_endereco.pais" />
                </div><br>
                <a @click.prevent="adicionaEndereco">[+]</a>

            </div>

            <hr>

            <!-- Dados Bancários -->
            <span class="titulo_bloco">Dados bancários</span>

            <div v-for="(dado_bancario, index) in dados_bancarios">
                <span class="titulo_bloco"># {{index+1}}:</span> <a @click="removeDadosBancarios(dado_bancario.id)">X</a> <br>
                <div class="valor">
                    <span class="campo">Banco</span>
                    <input autocomplete="off" type="text" placeholder=" " name="dado_bancario.nome_banco" v-model="dado_bancario.nome_banco" />
                </div><br>
                <div class="valor">
                    <span class="campo">Agência</span>
                    <input autocomplete="off" type="text" placeholder=" " name="dado_bancario.agencia" v-model="dado_bancario.agencia" />
                </div><br>
                <div class="valor">
                    <span class="campo">Conta</span>
                    <input autocomplete="off" type="text" placeholder=" " name="dado_bancario.conta" v-model="dado_bancario.conta" />
                </div><br>
                <div class="valor">
                    <span class="campo">Tipo</span>
                    <select name="dado_bancario.tipo_conta_id" v-model="dado_bancario.tipo_conta_id">
                        <option v-for="tipo_conta in atributos.tipos_conta_bancaria" :value="tipo_conta.id">
                            {{ tipo_conta.valor }}
                        </option>
                    </select>
                </div><br><br>

            </div>
            <!-- Add novos dados bancários -->
            <a @click="mostraDadosBancariosBox = !mostraDadosBancariosBox" class="link_abrir_box">[adicionar dados bancários]</a>
            <div v-if="mostraDadosBancariosBox">
                <span class="campo">--- Novos Dados Bancários</span><br>
                <div class="valor">
                    <span class="campo">Banco</span>
                    <input @input="novos_dados_bancarios.nome_banco = $event.target.value" autocomplete="off" type="text" placeholder=" " name="novos_dados_bancarios.nome_banco" v-model="novos_dados_bancarios.nome_banco" />
                </div><br>
                <div class="valor">
                    <span class="campo">Agência</span>
                    <input @input="novos_dados_bancarios.agencia = $event.target.value" autocomplete="off" type="text" placeholder=" " name="novos_dados_bancarios.agencia" v-model="novos_dados_bancarios.agencia" />
                </div><br>
                <div class="valor">
                    <span class="campo">Conta</span>
                    <input @input="novos_dados_bancarios.conta = $event.target.value" autocomplete="off" type="text" placeholder=" " name="novos_dados_bancarios.conta" v-model="novos_dados_bancarios.conta" />
                </div><br>
                <div class="valor">
                    <span class="campo">Tipo</span>
                    <select @change="novos_dados_bancarios.tipo_conta_id = $event.target.value" name="dado_bancario.tipo_conta_id" v-model="novos_dados_bancarios.tipo_conta_id">
                        <option v-for="tipo_conta in atributos.tipos_conta_bancaria" :value="tipo_conta.id">
                            {{ tipo_conta.valor }}
                        </option>
                    </select>
                </div><br>

                <a @click.prevent="adicionaDadosBancarios">[+]</a>

            </div>

        </div>

    </div>

</template>

<script>

    import { eventBus } from '../../estudiobaile';
    import modal from '../modals/modal_delete';
    import editbar from '../editbar';
    import { TheMask } from 'vue-the-mask';

    export default {
        components: {
            modal,
            editbar,
            TheMask
        },
        created() {
            this.getPessoa(this.$route.params.id);
            this.jQuery();
            //reticências em strings maiores que "n"
            String.prototype.trunc = function(n){
                return this.substr(0, n-1) + (this.length > n ? '...' : '');
            };
            //basepath
            this.root = ROOT;
            //lightbox
            lightbox.option({
                'disableScrolling': true,
            });
        },
        mounted() {
            //evento - salvar formulário
            eventBus.$on('editbar-salvar', () => {
                this.salvaForm();
            });
            //evento - mostrar modal de exclusão
            eventBus.$on('editbar-excluir', () => {
                this.modalDelete = true;
            });
            //evento - excluir registro
            eventBus.$on('excluir-pf', () => {
                this.deletePessoa();
            });
            //evento - exportar
            eventBus.$on('editbar-exportar', () => {
                //
            });

        },
        data() {
            return {
                //Models
                pessoa: {},
                contatos: [],
                enderecos: [],
                arquivos: [],
                dados_bancarios: [],
                tags: [],
                atributos: [],
                estados_civis: {},
                generos: {},
                projetos: [],
                pessoas_juridicas_relacionadas: [],
                nova_dt_nascimento: '',
                //Campos de inclusão
                root: '',
                pessoa_juridica_id: '',
                nova_chancela: '',
                novo_email: '',
                novo_telefone: '',
                novo_endereco: {rua:'',numero:'',complemento:'',bairro:'',cep:'',cidade:'',estado:'',pais:''},
                novos_dados_bancarios: {nome_banco:'',agencia:'',conta:'',tipo_conta_id:''},
                tags_atuais: [],
                arquivo_atual: {name: 'Selecione um arquivo'},
                descricao_arquivo: '',
                mensagem_upload: '',
                id_destaque: '',
                imagem_destaque: '',
                imagem_destaque_original: '',
                //Condicionais
                mostraChancelaPjBox: false,
                adicionaEmail: false,
                adicionaTel: false,
                mostraEnderecoBox: false,
                mostraDadosBancariosBox: false,
                mostraMei: false,
                destaqueAtivo: false,
                item_carregado: false,
                modalDelete: false,
            }
        },
        watch: {
            '$route' (destino) {
                this.getPessoa(destino.params.id);
                eventBus.$emit('changePessoaFisica');
                this.jQuery();
            },
            'mostraMei' (check) {
                if(!check) {
                    this.pessoa.cnpj = null;
                    this.pessoa.razao_social = null
                }
            }
        },
        computed: {
            emails: function() {
                return this.contatos.filter(x => x.tipo_contato_id == 1);
            },
            telefones: function() {
                return this.contatos.filter(x => x.tipo_contato_id == 2);
            }
        },
        methods: {
            console: function(x){ console.log(x) },
            getPessoa: function(id){
                this.item_carregado = false;
                this.imagem_destaque = `${this.root}/img/perfil_vazio.png`;
                axios.get('/ajax/pf/' + id)
                    .then(res => {
                        eventBus.$emit('getPessoaFisica', this.$route.params.id);
                        let dados = res.data;
                        this.pessoa = dados.pessoa_fisica;
                        this.pessoa.estado_civil = dados.estado_civil;
                        this.contatos = dados.contatos;
                        this.enderecos = dados.enderecos;
                        this.arquivos = dados.arquivos;
                        this.dados_bancarios = dados.dados_bancarios;
                        this.tags = dados.tags;
                        this.projetos = dados.projetos;
                        this.pessoas_juridicas_relacionadas = dados.pessoas_juridicas_relacionadas;
                        this.atributos = dados.atributos;

                        //campo MEI
                        if(this.pessoa.cnpj !== null || this.pessoa.razao_social !== null) {
                            this.mostraMei = true;
                        }

                        //imagem de destaque
                        this.getImagemDestaque();

                        //data de nascimento formatada
                        if(this.pessoa.dt_nascimento !== null && typeof this.pessoa.dt_nascimento !== "undefined") {
                            let dt = this.pessoa.dt_nascimento.split('-');
                            this.nova_dt_nascimento = `${dt[2]}/${dt[1]}/${dt[0]}`;
                        }
                    })
                    .then(() => this.item_carregado = true);
            },
            salvaForm: function(){
                this.item_carregado = false;
                axios.post('/ajax/pf/save', {
                    pessoa: this.pessoa,
                    contatos: this.contatos,
                    enderecos: this.enderecos,
                    arquivos: this.arquivos,
                    dados_bancarios: this.dados_bancarios,
                    tags: this.tags_atuais,
                })
                .then(res => {
                    this.pessoa = res.data;
                    eventBus.$emit('foiSalvoPessoaFisica', this.pessoa);
                })
                .then(() => this.item_carregado = true);
            },
            formataDataNascimento: function(dt_nascimento){
                if(dt_nascimento.length == 10) {
                    let dt = dt_nascimento.split('/');
                    let dia = dt[0]; let mes = dt[1]; let ano = dt[2];
                    this.pessoa.dt_nascimento = `${ano}-${mes}-${dia}`;
                }
            },
            deletePessoa: function(){
                axios.post('/ajax/pf/delete', {
                    pessoa: this.$route.params.id,
                }).then(res => {
                    if(typeof res.data !== "string") {
                        eventBus.$emit('deletePessoaFisica', res.data);
                        this.$router.push({ name: 'pf-index'});
                    } else
                        console.log('Erro ao deletar pessoa física');
                });
            },
            adicionaChancelaPj: function(){
                this.item_carregado = false;
                axios.post('/ajax/pf/ajaxAddChancelaPj', {
                    pessoa_fisica_id: this.$route.params.id,
                    pessoa_juridica_id: this.pessoa_juridica_id,
                    nova_chancela: this.nova_chancela,

                })
                .then(res => {
                    if(typeof res.data[0] !== "string") {
                        this.pessoas_juridicas_relacionadas = res.data[0];
                        this.atributos.chancelas = res.data[1];
                        this.pessoa_juridica_id = '';
                        this.nova_chancela = '';
                        this.mostraChancelaPjBox = false;
                    }
                })
                .then(() => this.item_carregado = true);
            },
            removeChancelaPj: function(pessoa_juridica_id, chancela_id){
                this.item_carregado = false;
                axios.post('/ajax/pf/ajaxRemoveChancelaPj', {
                    chancela: chancela_id,
                    pessoa_juridica_id: pessoa_juridica_id,
                    pessoa_fisica_id: this.$route.params.id,
                })
                .then(res => {
                    this.pessoas_juridicas_relacionadas = res.data;
                })
                .then(() => this.item_carregado = true);
            },
            mostraChancelaPjBoxMetodo: function(){
                this.mostraChancelaPjBox = !this.mostraChancelaPjBox;
                this.jQuery();
            },
            adicionaContato: function(){
                this.item_carregado = false;
                axios.post('/ajax/pf/addContato', {
                    pessoa_id: this.$route.params.id,
                    email: this.novo_email,
                    telefone: this.novo_telefone
                })
                .then(res => {
                    console.log(res.data);
                    if(typeof res.data !== "string") {
                        this.contatos = res.data;
                    }
                    this.novo_email = '';
                    this.novo_telefone = '';
                    this.adicionaEmail = false;
                    this.adicionaTel = false;
                })
                .then(() => this.item_carregado = true);
            },
            removeContato: function(id){
                this.item_carregado = false;
                axios.post('/ajax/pf/removeContato', {
                    contato_id: id,
                    pessoa_id: this.$route.params.id,
                })
                .then(res => {
                    if(typeof res.data !== "string") {
                        this.contatos = res.data;
                    }
                })
                .then(() => this.item_carregado = true);
            },
            adicionaEndereco: function(){
                this.item_carregado = false;
                axios.post('/ajax/pf/addEndereco', {
                    pessoa_id: this.$route.params.id,
                    endereco: this.novo_endereco
                })
                .then(res => {
                    if(typeof res.data !== "string") {
                        this.enderecos = res.data;
                        this.novo_endereco = {};
                        this.mostraEnderecoBox = false;
                    }
                })
                .then(() => this.item_carregado = true);
            },
            removeEndereco: function(id){
                this.item_carregado = false;
                axios.post('/ajax/pf/removeEndereco', {
                    endereco_id: id,
                    pessoa_id: this.$route.params.id,
                })
                .then(res => {
                    console.log(res.data);
                    this.enderecos = res.data;
                })
                .then(() => this.item_carregado = true);
            },
            adicionaDadosBancarios: function(){
                this.item_carregado = false;
                axios.post('/ajax/pf/addDadosBancarios', {
                    pessoa_id: this.$route.params.id,
                    dados_bancarios: this.novos_dados_bancarios
                })
                .then(res => {
                    if(typeof res.data !== "string") {
                        this.dados_bancarios = res.data;
                        this.novos_dados_bancarios = {};
                        this.mostraDadosBancariosBox = false;
                    }
                })
                .then(() => this.item_carregado = true);
            },
            removeDadosBancarios: function(id){
                this.item_carregado = false;
                axios.post('/ajax/pf/removeDadosBancarios', {
                    dados_bancarios_id: id,
                    pessoa_id: this.$route.params.id,
                })
                .then(res => {
                    this.dados_bancarios = res.data;
                })
                .then(() => this.item_carregado = true);
            },
            selecionaTags: function(data){
                //console.log(data);
            },
            upload: function() {
                this.item_carregado = false;
                let formData = new FormData();
                formData.append('arquivo', this.arquivo_atual);
                formData.append('pessoa_id', this.$route.params.id);
                formData.append('descricao_arquivo', this.descricao_arquivo);

                axios.post('/ajax/pf/upload',
                    formData, {
                        headers: { 'Content-Type': 'multipart/form-data' },
                    }
                )
                .then(res => {
                    if(typeof res.data !== "string") {
                        this.mensagem_upload = res.data['mensagem_upload'];
                        this.arquivos = res.data['arquivos'];
                        this.arquivo_atual = {};
                        this.descricao_arquivo = '';
                        this.$refs.arquivo.value = '';
                    } else {
                        console.log('Arquivo inválido');
                    }
                })
                .then(() => this.item_carregado = true);
            },
            removeArquivo: function(id) {
                this.item_carregado = false;
                axios.post('/ajax/pf/removeArquivo', {
                    arquivo_id: id,
                    pessoa_id: this.$route.params.id,
                })
                .then(res => {
                    this.arquivos = res.data['arquivos'];
                    if(res.data['remove_destaque'] === true) {
                        this.imagem_destaque = `${this.root}/img/perfil_vazio.png`;
                        this.destaqueAtivo = false;
                    }
                })
                .then(() => this.item_carregado = true);
            },
            setArquivoAtual() {
                this.arquivo_atual = this.$refs.arquivo.files[0];
            },
            setImagemDestaque: function(arquivo_id) {
                axios.post('/ajax/pf/setImagemDestaque', {
                    arquivo_id: arquivo_id,
                    pessoa_id: this.$route.params.id,
                }).then(res => {
                    this.id_destaque = res.data['imagem_destaque']['id'];
                    this.arquivos = res.data['arquivos'];
                    if(this.id_destaque === 0) {
                        this.imagem_destaque = `${this.root}/img/perfil_vazio.png`;
                        this.destaqueAtivo = false;
                    }
                    else {
                        this.imagem_destaque = `${this.root}/thumbs/pessoas_fisicas/${this.$route.params.id}/${res.data['imagem_destaque']['nome']}`;
                        this.imagem_destaque_original = `${this.root}/uploads/pessoas_fisicas/${this.$route.params.id}/${res.data['imagem_destaque']['nome']}`;
                        this.destaqueAtivo = true;
                    }
                });
            },
            getImagemDestaque: function() {
                axios.post('/ajax/pf/getImagemDestaque', {
                    pessoa_id: this.$route.params.id,
                }).then(res => {
                    if(typeof res.data !== "string") {
                        this.id_destaque = res.data.id;
                        this.imagem_destaque = `${this.root}/thumbs/pessoas_fisicas/${this.$route.params.id}/${res.data.nome}`;
                        this.imagem_destaque_original = `${this.root}/uploads/pessoas_fisicas/${this.$route.params.id}/${res.data.nome}`;
                        this.destaqueAtivo = true;
                    }
                    else {
                        this.imagem_destaque = `${this.root}/img/perfil_vazio.png`;
                        this.destaqueAtivo = false;
                    }
                });
            },
            jQuery: function(){

                //Instancia atual do Vue
                let Vue = this;

                $(document).ready(function(){
                    //Carrega select2 de tags
                    $('#tags_list').val('').select2({
                        placeholder: "Digite as tags",
                        tags: true,
                        multiple: true,
                        tokenSeparators: [","],
                        createTag: function(newTag) {
                            if ($.trim(newTag.term) === '') { return null; }
                            return {
                                id: 'new:' + newTag.term,
                                text: newTag.term + ' (novo)'
                            };
                        }
                    }).on('change', function(){
                        Vue.tags_atuais = $(this).val();
                    });

                    //Preenche tags selecionadas (timeout 1s)
                    let id_atual = window.location.href.split('/view/')[1];
                    let tags_selecionadas = [];
                    $.get('/ajax/pf/getTagsSelecionadas/' + id_atual).done(function(data) {
                        setTimeout(function(){
                            tags_selecionadas = data;
                            let tags_ids = [];
                            for (let i = 0; i < tags_selecionadas.length; i++) {
                                tags_ids.push(tags_selecionadas[i]['id']);
                            }
                            $('#tags_list').val(tags_ids).trigger('change');
                        }, 1000);
                    }).fail(function() {
                        return false;
                    });

                    //Carrega select2 de pessoas físicas
                    $('.pj_lista').select2({
                        placeholder: "Digite um nome",
                        tags: false,
                        multiple: false,
                        tokenSeparators: [","],
                        dropdownAutoWidth : true,
                        //dropdownCssClass : 'select2-dropdown-custom',
                        //minimumInputLength: 1,
                        createTag: function(newTag) {
                            if ($.trim(newTag.term) === '') { return null; }
                            return {
                                id: 'new:' + newTag.term,
                                text: newTag.term + ' (novo)'
                            };
                        },
                    }).on('change', function(){
                        Vue.pessoa_juridica_id = $(this).val();
                    });

                    //Cargos

                    //Carrega select2 de cargos
                    $('.chancelas_pj_lista').select2({
                        placeholder: "Digite uma chancela",
                        tags: true,
                        multiple: false,
                        tokenSeparators: [","],
                        createTag: function(newTag) {
                            if ($.trim(newTag.term) === '') { return null; }
                            return {
                                id: 'new:' + newTag.term,
                                text: newTag.term + ' (novo)'
                            };
                        }
                    }).on('change', function(){
                        Vue.nova_chancela = $(this).val();
                    });

                });
            },
        }
    }
</script>