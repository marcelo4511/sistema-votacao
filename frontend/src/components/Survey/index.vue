<template>
<div>
      <form novalidate class="md-layout" @submit.prevent="validateSurvey">
      <md-card class="md-layout-item">
        <md-card-header>
          <div class="md-title">Enquete</div>
        </md-card-header>

        <md-card-content>
          <div class="md-layout md-gutter">

            <div class="md-layout-item md-small-size-100">
              <md-field :class="getValidationClass('title')">
                <label for="title">Título</label>
                <md-input name="title" id="title" autocomplete="given-name" v-model="form.title" :disabled="sending" />
                <span class="md-error" v-if="!$v.form.title.required">O Título é requirido</span>
                <span class="md-error" v-else-if="!$v.form.title.minlength">Título inválido</span>
              </md-field>
            </div>

            <div class="md-layout-item md-small-size-100">
              <md-field :class="getValidationClass('dateinicial')">
                <label for="dateinicial">Data Inicial</label>
                <md-input placeholder="data inicial" type="date" name="dateinicial" autocomplete="given-name" :disabled="sending" id="dateinicial" v-model="form.dateinicial"/>
                <span class="md-error" v-if="!$v.form.dateinicial.required">A data inicial é requirida</span>
              </md-field>
            </div>
          

            <div class="md-layout-item md-small-size-100">
              <md-field :class="getValidationClass('datefinal')">
                <label for="datefinal">Data Final</label>
                <md-input type="date" name="datefinal" placeholder="data final" autocomplete="given-name" :disabled="sending" id="datefinal" v-model="form.datefinal"/>
                <span class="md-error" v-if="!$v.form.datefinal.required">A data final é requirida</span>
              </md-field>
            </div>
          </div>

          <div class="md-layout md-gutter">

            <div class="md-layout-item md-small-size-100">
              <md-field :class="getValidationClass('option1')">
                <label for="option1">Opção 1</label>
                <md-input name="option1" id="option1" autocomplete="given-name" v-model="form.option1" :disabled="sending" />
                <span class="md-error" v-if="!$v.form.option1.required">A opção 1 é requirida</span>
                <span class="md-error" v-else-if="!$v.form.option1.minlength">Opção 1 inválida</span>
              </md-field>
            </div>
            
            <div class="md-layout-item md-small-size-100">
              <md-field :class="getValidationClass('option2')">
                <label for="option2">Opção 2</label>
                <md-input name="option2" id="option2" autocomplete="given-name" v-model="form.option2" :disabled="sending" />
                <span class="md-error" v-if="!$v.form.option2.required">A opção 2 é requirida</span>
                <span class="md-error" v-else-if="!$v.form.option2.minlength">Opção 2 inválida</span>
              </md-field>
            </div>

            <div class="md-layout-item md-small-size-100">
              <md-field :class="getValidationClass('option3')">
                <label for="option3">Opção 3</label>
                <md-input name="option3" id="option3" autocomplete="given-name" v-model="form.option3" :disabled="sending" />
                <span class="md-error" v-if="!$v.form.option3.required">A opção 3 é requirida</span>
                <span class="md-error" v-else-if="!$v.form.option3.minlength">Opção 3 inválida</span>
              </md-field>
            </div>
          </div>  
         
        </md-card-content>

        <md-progress-bar md-mode="indeterminate" v-if="sending" />

        <md-card-actions>
          <md-button v-if="isEdit === false" type="submit" class="md-raised md-primary" :disabled="sending">Criar Enquete</md-button>
          <md-button v-else-if="isEdit === true" type="button" class="md-raised md-primary" @click="updateSurvey">Atualizar Enquete</md-button>
        </md-card-actions>
      </md-card>

      <md-snackbar :md-active.sync="surveySaved">A enquete foi salva com sucesso!</md-snackbar>
      <md-snackbar :md-active.sync="surveyUpdated">A enquete foi atualizada com sucesso!</md-snackbar>
      
      
    </form>

    <div class="row d-flex justify-content-between">

      <select name="" id="" class="form-control col-md-1 mt-5 ml-4" v-model="perPage" @change="navigate">
          <option selected default value="0"></option>
          <option :value="5">5</option>
          <option :value="10">10</option>
          <option :value="15">15</option>
      </select>
      <input type="search" style="float:center;" class="form-control col-md-3 mt-5 mr-5" placeholder="Buscar" v-model.trim="search" @input="getSurvey">
    </div>

      <md-table class="mt-2">
        <md-table-row>
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
          <md-table-row v-for="(form,key) in survey" :key="key">

             <tr class="" v-if="survey.length === 0">
              <td class="lead text-center" :colspan="columns.length + 1">não há registros.</td>
                <td class="lead text-center">não há registros.</td>
            </tr>
            <md-table-cell>{{form.title}}</md-table-cell>
            <md-table-cell>{{form.dateinicial | formatDate}}</md-table-cell>
            <md-table-cell>{{form.datefinal | formatDate}}</md-table-cell>
            <md-table-cell>{{form.status}}</md-table-cell>
            <md-table-cell>
              <md-button :to="`/survey/${form.id}/vote`" v-show="form.status === 'em andamento'"  tag="button" class="md-raised md-black linha"><i class="fa fa-check-square">Votar</i></md-button>
              <md-button :to="`/survey/${form.id}/vote`" v-show="form.status !== 'em andamento'" disabled="disabled" tag="button" class="md-raised md-black linha" ><i class="fa fa-check-square">Votar</i></md-button>
              <md-button class="md-raised md-primary" v-on:click="editSurvey(form)"><i class="fa fa-pencil"></i> Editar</md-button>
              <md-button class="md-raised md-accent" v-on:click="removeSurvey(form)"><i class="fa fa-trash"></i>Deletar</md-button>
            </md-table-cell>
          </md-table-row>
      </md-table>

      <div class="mt-2" v-show="survey == 0">
          <div style="text-align:center;">Não há enquetes.</div>
      </div>

      <div class="form-row d-flex justify-content-between mt-1">
      <span> &nbsp; <i>Mostrando de  {{ pagination.from }} até  {{ pagination.to }} de {{ pagination.total }} registros.</i></span>
      <nav v-if="pagination && survey.length > 0" >
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
  import axios from 'axios'
  import User from "../../config/User";
  import { validationMixin } from 'vuelidate'
  import {
    required,
    minLength
  } from 'vuelidate/lib/validators'

  export default {
    name: 'FormValidation',
    mixins: [validationMixin],
    data: () => ({
      form: {
        title: '',
        dateinicial: new Date,
        datefinal: new Date,
        option1: null,
        option2: null,
        option3: null,
        status_id:''
      },
      search:'',
      survey:[],
      url: '',
      pagination: {
        data: { to: 1, from: 1 }
      },
      offset: 4,
      currentPage: 1,
      perPage: 5,
      isEdit:false,
      surveySaved: false,
      surveyUpdated:false,
      sending: false,
      lastUser: null,
      columns:['title','dateinicial','datefinal','status'],
      sortedColumn:['title'],
      order: 'asc',
    }),
    validations: {
      form: {
        title: {
          required,
          minLength: minLength(3)
        },
        dateinicial: {
          required
        },
        datefinal: {
          required,
        },
        option1:{
          required,
        },
        option2:{
          required,
        },
        option3:{
          required,
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
        if(this.columns[0] == 'title') {
          return this.columns[0] = 'Título'
        }
      },
      clearForm () {
        this.$v.$reset()
        this.form.title = null
        this.form.dateinicial = null
        this.form.datefinal = null
        this.form.option1 = null
        this.form.option2 = null
        this.form.option3 = null
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
    getSurvey(){
        this.navigate()
    },
     async surveyUser () {
        this.sending = true
         await axios.post('http://localhost:8000/api/survey',{
            title:this.form.title,
            dateinicial:this.form.dateinicial,
            datefinal:this.form.datefinal,
            option1:this.form.option1,
            option2:this.form.option2,
            option3:this.form.option3,

         }).then(resposta => {
            this.survey.push(resposta.data)
            this.$toasted.global.defaultSuccess()
            this.navigate()
         })
        
        window.setTimeout(() => {
          this.title = `${this.form.title}`
          this.surveySaved = true
          this.sending = false
          this.clearForm()
        }, 1500)
      },
       editSurvey(form){   
        this.isEdit = true
        this.form = form      
      },
       serialNumber(key) {
      return (this.currentPage - 1) * this.perPage + 1 + key
    },
      updateSurvey(){
        axios.put(`http://localhost:8000/api/survey/${this.form.id}`,{
           title:this.form.title,
            dateinicial:this.form.dateinicial,
            datefinal:this.form.datefinal,
            option1:this.form.option1,
            option2:this.form.option2,
            option3:this.form.option3,

         }).then(resposta => {
            this.survey.push(resposta.data)
            this.isEdit = false
            this.navigate()
         })
        
        window.setTimeout(() => {
          this.title = `${this.form.title}`
          this.surveyUpdated = true
          this.sending = false
          this.clearForm()
        }, 1500)
      },
      
              
       validateSurvey () {
           this.$v.$touch()
            if (!this.$v.$invalid) {
              this.surveyUser()
            }
      },
        navigate(){
          
          axios.get(`http://localhost:8000/api/survey?page=${this.currentPage}&pesquisa=${this.search}&column=${this.sortedColumn}&order=${this.order}&per_page=${this.perPage}`)
          .then( ({ data }) => {
            this.survey = data.data
            this.pagination = data
            this.survey.map(form => {
                  let dateNow = new Date()
                   dateNow.toLocaleDateString("pt-BR")
                  let dateinicial = new Date(form.dateinicial)
                  dateinicial.toLocaleDateString("pt-BR")
                  let datefinal = new Date(form.datefinal)
                  datefinal.toLocaleDateString("pt-BR")

                  if(dateinicial <= dateNow && datefinal >= dateinicial && datefinal >= dateNow){
                  return form.status = 'em andamento'
                } else if(datefinal <= dateNow){
                  return form.status = 'finalizada'
                }else if(dateinicial >= dateNow ){
                  return form.status = 'não iniciada'
                }
            })
            
        })
      },
      changePage(pageNumber) {
      this.currentPage = pageNumber
      this.navigate()
    },
      async removeSurvey(form){
         let response = confirm(`Está certo de que fazer isso??${form.title}`)
          if(response) {
            await axios.delete(`http://localhost:8000/api/survey/${form.id}`,{
              }).then(res => {
                this.survey.splice(res.data.id,form)
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

      if(value == 'title') {
        value = 'Título'
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