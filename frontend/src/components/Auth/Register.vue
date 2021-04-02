<template>
  <div class="home col-5 mx-auto py-5 mt-5">
    <h1 class="text-center">Register</h1>
    <div class="card">
      <div class="card-body">
        <div class="form-group">
          <label for="name">Nome:</label>
          <input
            type="text"
            v-model="form.nome"
            :class="errors.nome ? 'form-control is-invalid' : 'form-control'"
            id="name"
          />
          <span class="text-danger" v-if="errors.nome">
            {{ errors.nome[0] }}
          </span>

        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input
            type="email"
            v-model="form.email"
            :class="errors.email ? 'form-control is-invalid' :'form-control'"
            id="email"
          />
          <span class="text-danger" v-if="errors.email">
            {{ errors.email[0] }}
          </span>
        </div>
        <div class="form-group">
          <label for="password">Senha:</label>
          <input
            type="password"
            v-model="form.password"
            :class="errors.password ? 'form-control is-invalid' :'form-control'"
            id="password"
          />
          <span class="text-danger" v-if="errors.password">
            {{ errors.password[0] }}
          </span>
        </div>
        <div class="form-group">
          <label for="password_confirmation">Confirmar Senha:</label>
          <input
            type="password"
            v-model="form.password_confirmation"
            :class="errors.password_confirmation ? 'form-control is-invalid' :'form-control'"
            id="password_confirmation"
          />
          <span class="text-danger" v-if="errors.password_confirmation">
            {{ errors.password[0] }}
          </span>
        </div>
        <button
          type="submit"
          @click.prevent="register"
          class="btn btn-primary btn-block"
        >
          Register
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import User from "../../config/User";

export default {
  data() {
    return {
      form: {
        nome: "",
        email: "",
        password: "",
        password_confirmation: ""
      },
      errors: []
    };
  },

  methods: {
    register() {
      User.register(this.form)
        .then(() => {
          this.$router.push({ name: "login" });
        })
        .catch(error => {
          if (error.response.status === 422) {
            this.errors = error.response.data.errors;
            console.log(this.errors.confirmed)
          }
        });
    }
  }
};
</script>
