<template>
<div>
      <form novalidate class="md-layout" @submit.prevent="validateUsers">
      <md-card class="md-layout-item">
        <md-card-header>
          <h5 class="md-nome">Usuários</h5>
        </md-card-header>

        <md-card-content>
          <div class="md-layout md-gutter">
            <div class="md-layout-item md-small-size-100">
              <md-field :class="getValidationClass('nome')">
                <label for="nome">Nome</label>
                <md-input name="nome" id="nome" autocomplete="given-name" v-model="form.nome" :disabled="sending" />
                <span class="md-error" v-if="!$v.form.nome.required">O Nome é requirido</span>
                <span class="md-error" v-else-if="!$v.form.nome.minlength">Nome é no mínimo 3 caracteres</span>
              </md-field>
            </div>
          </div>
          <div class="md-layout md-gutter">

            <div class="md-layout-item md-small-size-100">
              <md-field :class="getValidationClass('email')">
                <label for="option1">Email</label>
                <md-input type="email" name="email" id="email" autocomplete="email" v-model="form.email" :disabled="sending" />
                <span class="md-error" v-if="!$v.form.email.required">O E-mail é requerido</span>
                <span class="md-error" v-else-if="!$v.form.email.email">O E-mail é inválido</span>
              </md-field>
            </div>
            
            <div class="md-layout-item md-small-size-100">
              <md-field :class="getValidationClass('password')">
                <label for="password">Senha</label>
                <md-input name="password" id="password" type="password" autocomplete="password" v-model="form.password" :disabled="sending" />
                <span class="md-error" v-if="!$v.form.password.required">A senha é requirida</span>
                <span class="md-error" v-else-if="!$v.form.password.minlength">A senha é no mínimo 8 caracteres</span>
              </md-field>
            </div>
          </div>  
        </md-card-content>

        <md-progress-bar md-mode="indeterminate" v-if="sending" />

        <md-card-actions>
          <md-button v-if="isEdit === false" type="submit" class="md-raised md-primary" :disabled="sending">Criar Usuário</md-button>
          <md-button v-else-if="isEdit === true" type="button" class="md-raised md-primary" @click="updateUsers">Atualizar Usuário</md-button>
        </md-card-actions>
      </md-card>

      <md-snackbar :md-active.sync="UsersSaved">O usuário foi salvo com sucesso!</md-snackbar>
      <md-snackbar :md-active.sync="UsersUpdated">O usuário foi atualizado com sucesso!</md-snackbar>
    </form>

    <div class="row d-flex justify-content-between">
      <select name="" id="" class="form-control col-md-1 mt-5 ml-4" v-model="perPage" @change="navigate">
          <option selected default value="0"></option>
          <option :value="5">5</option>
          <option :value="10">10</option>
          <option :value="15">15</option>
      </select>
      <input type="search" style="float:center;" class="form-control col-md-3 mt-5 mr-5" placeholder="Buscar" v-model.trim="search" @input="getUsers">
    </div>

      <md-table class="mt-2">
        <md-table-row >
          <th v-for="column in columns" :key="column" @click="sortByColumn(column)"
              class="table-head">
            {{ column| columnHead }}
            {{ column| col }}
            <span v-if="column === sortedColumn">
              <i v-if="order === 'asc' " class="fa fa-arrow-up"></i>
              <i v-else class="fa fa-arrow-down"></i>
            </span>
          </th>
    
        </md-table-row>
          <md-table-row  width="10px" v-for="(form,key) in users" :key="key">
             <tr class="" v-if="users.length === 0">
                <td class="lead text-center" :colspan="columns.length + 1">não há registros.</td>
                <td class="lead text-center">não há registros.</td>
            </tr>
            <md-table-cell>{{form.nome}}</md-table-cell>
            <md-table-cell>{{form.email}}</md-table-cell>
            <md-table-cell>
              <md-button class="md-raised md-primary" v-on:click="editUsers(form)"><i class="fa fa-pencil"></i> Editar</md-button>
              <md-button class="md-raised md-accent" v-on:click="removeUsers(form)"><i class="fa fa-trash"></i>Deletar</md-button>
            </md-table-cell>
          </md-table-row>
      </md-table>

      <div class="mt-2" v-show="users == 0">
          <div style="text-align:center;">Não há Usuários.</div>
      </div>

    <div class="form-row d-flex justify-content-between mt-1">
      <span> &nbsp; <i>Mostrando de  {{ pagination.from }} até  {{ pagination.to }} de {{ pagination.total }} registros.</i></span>
      <nav v-if="pagination && users.length > 0" >
        <ul class="pagination">
          <li class="page-item" :class="{'disabled' : currentPage === 1}">
            <a class="page-link" href="#" @click.prevent="changePage(currentPage - 1)">Anterior</a>
          </li>
          <li v-for="page in pagesNumber" :key="page" class="page-item"
              :class="{'active': page == pagination.current_page}">
            <a href="javascript:void(0)" @click.prevent="changePage(page)" class="page-link">{{ page }}</a>
          </li>
          <li class="page-item" :class="{'disabled': currentPage === pagination.last_page }">
            <a class="page-link" href="#" @click.prevent="changePage(currentPage + 1)">Próximo</a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</template>

<script>
  import Api from '../../config/api'
  import User from "../../config/User";
  import { validationMixin } from 'vuelidate'
  import { required,email,minLength } from 'vuelidate/lib/validators'

  export default {
    name: 'FormValidation',
    mixins: [validationMixin],
    data: () => ({
      form: {
        nome: null,
        email: null,
        password: null,
      },
      search:'',
      users:[],
      url: '',
      pagination: {
        data: { to: 1, from: 1 }
      },
      offset: 4,
      currentPage: 1,
      perPage: 5,
      isEdit:false,
      UsersSaved: false,
      UsersUpdated:false,
      sending: false,
      lastUser: null,
      columns:['nome','email'],
      sortedColumn:['nome'], 
      order: 'asc',
    }),
    validations: {
      form: {
        nome: {
          required,
          minLength: minLength(3)
        },
        email: {
          required,
          email,
        },
        password: {
          required,
          minLength: minLength(8)
        },
      }
    },
    created(){
      this.navigate()
    },

    methods: {
      getValidationClass (fieldName) {
        const field = this.$v.form[fieldName]

        if (field) {
          return {
            'md-invalid': field.$invalid && field.$dirty
          }
        }
      },
      
      getIf(){
        if(this.columns[0] == 'nome') {
          return this.columns[0] = 'Título'
        }
      },
      clearForm () {
        this.$v.$reset()
        this.form.nome = null
        this.form.email = null
        this.form.password = null
      },
        sortByColumn(column) {
      if (column === this.sortedColumn) {
        this.order = (this.order === 'asc') ? 'desc' : 'asc'
      } else {
        this.sortedColumn = column
        this.order = 'asc'
      }
      this.navigate()
    },
    getUsers(){
        this.navigate()
    },
     async UsersUser () {
        this.sending = true
         await Api().post(`/user`,this.form).then(resposta => {
            this.users.push(resposta.data)
            this.$toasted.global.defaultSuccess()
            this.navigate()
         })
        
        window.setTimeout(() => {
          this.nome = `${this.form.nome}`
          this.UsersSaved = true
          this.sending = false
          this.clearForm()
        }, 1500)
      },
      editUsers(form){   
        this.isEdit = true
        this.form = form      
      },
      serialNumber(key) {
        return (this.currentPage - 1) * this.perPage + 1 + key
      },
      updateUsers(){
        Api().put(`/user/${this.form.id}`,this.form).then(resposta => {
            this.users.push(resposta.data)
            this.isEdit = false
            this.navigate()
         })
        
        window.setTimeout(() => {
          this.nome = `${this.form.nome}`
          this.UsersUpdated = true
          this.sending = false
          this.clearForm()
        }, 1500)
      },
              
       validateUsers () {
        this.$v.$touch()
        if (!this.$v.$invalid) {
          this.UsersUser()
        }
      },
        navigate(){
          Api().get(`users?page=${this.currentPage}&pesquisa=${this.search}&column=${this.sortedColumn}&order=${this.order}&per_page=${this.perPage}`).then( ({ data }) => {
            this.users = data.data
            this.pagination = data
        })
      },
      changePage(pageNumber) {
      this.currentPage = pageNumber
      this.navigate()
    },
      async removeUsers(form){
         let response = confirm(`Está certo de quer fazer isso??${form.nome}`)
          if(response) {
            await Api().delete(`user/${form.id}`).then(res => {
            this.users.splice(res.data.id,form)
            this.$toasted.global.defaultSuccess()
            this.navigate()
          })
         }
      }
    },
    computed:{
      pagesNumber() {
        if (!this.pagination.to) {
          return []
        }
        let from = this.pagination.current_page - this.offset
        if (from < 1) {
          from = 1
        }
        let to = from + (this.offset * 2)
        if (to >= this.pagination.last_page) {
          to = this.pagination.last_page
            
        }
        let pagesArray = []
        for (let page = from; page <= to; page++) {
          pagesArray.push(page)
        }
        return pagesArray
      },
      totalData() {
        return (this.pagination.to - this.pagination.from) + 1
      },
    },
    filters: {
      columnHead(value) {

      if(value == 'nome') {
        value = 'Nome'
      }
        return value.split('_').join(' ').toUpperCase()
      },
      col(value){
             if(value == 'dateinicial') {
              value = 'Data Inicial'
             }
      },
      t(value) {
        if(value == 'datefinal') {
          value = 'Data Final'
        }
      }
    },
    mounted() {
    User.auth().then(response => {
      this.$store.commit("AUTH_USER", response.data);
    });
  }
  }
</script>

<style scoped>
  .md-progress-bar {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
  }

  .linha{
    width:100px;
    margin:0px;
    margin-top: 6px;
    margin-right: 8px;
  }
</style>