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
      
      <input type="text" style="float:center;" class="form-control col-md-3 m-5" placeholder="Buscar" v-model="search">

      <md-table>
        <md-table-row>
          <md-table-head>Título</md-table-head>
          <md-table-head>Data Inicial</md-table-head>
          <md-table-head>Data Final</md-table-head>
          <md-table-head>Status</md-table-head>
          <md-table-head>Ações</md-table-head>
        </md-table-row>
          <md-table-row v-for="(form,i) in searching" :key="i">
            <md-table-cell>{{form.title}}</md-table-cell>
            <md-table-cell>{{form.dateinicial | formatDate}}</md-table-cell>
            <md-table-cell>{{form.datefinal | formatDate}}</md-table-cell>
            <md-table-cell>{{form.status}}</md-table-cell>
            <md-table-cell>
              <md-button :to="`/survey/${form.id}/vote`" v-show="form.status === 'em andamento'"  tag="button" class="md-raised md-black"><i class="fa fa-check-square">Votar</i></md-button>
              <md-button :to="`/survey/${form.id}/vote`" v-show="form.status !== 'em andamento'" disabled="disabled" tag="button" class="md-raised md-black"><i class="fa fa-check-square">Votar</i></md-button>
              <md-button class="md-raised md-primary" v-on:click="editSurvey(form)"><i class="fa fa-pencil"></i> Editar</md-button>
              <md-button class="md-raised md-accent" v-on:click="removeSurvey(form)"><i class="fa fa-trash"></i>Deletar</md-button>
            </md-table-cell>
          </md-table-row>
      </md-table>
  </div>
</template>

<script>
  //import api from '../../config/api'
  import axios from 'axios'
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
      isEdit:false,
      surveySaved: false,
      surveyUpdated:false,
      sending: false,
      lastUser: null
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
      this.getSurvey()
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
      clearForm () {
        this.$v.$reset()
        this.form.title = null
        this.form.dateinicial = null
        this.form.datefinal = null
        this.form.option1 = null
        this.form.option2 = null
        this.form.option3 = null
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
            this.getSurvey()
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
            this.getSurvey()
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
       async getSurvey(){
       await axios.get('http://localhost:8000/api/survey')
          .then( res => {
            this.survey = res.data

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
      async removeSurvey(form){
         let response = confirm(`Está certo de que fazer isso??${form.title}`)
          if(response) {
            await axios.delete(`http://localhost:8000/api/survey/${form.id}`,{
              }).then(res => {
                this.survey.splice(res.data.id,form)
            this.getSurvey()
          })
         }
      }
    },
    computed:{
      searching:function() {
            return this.survey.filter(form => {
                return form.title.includes(this.search)
            })
        },
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
</style>