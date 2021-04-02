<template>
  <div>
    <h4 class="text-center">Sistema de Enquetes</h4>
    <div class="d-flex align-items-center card border-0">
      <div class="card-body">
        <div class="form-group col-12">
          <label for="email">E-mail:</label>
          <input type="email" v-model="form.email" :class="errors.email ? 'form-control is-invalid' : 'form-control'" id="email" />
          <span class="text-danger" v-if="errors.email">{{ errors.email[0] }}</span>
        </div>
        <div class="form-group col-12">
          <label for="password">Senha:</label>
          <input type="password" v-model="form.password" :class="errors.password ? 'form-control is-invalid' : 'form-control'" id="password" />
          <span class="text-danger" v-if="errors.password">{{ errors.password[0] }}</span>
        </div>

        <div class="form-group col-12">
          <button @click.prevent="login" class="btn btn-primary btn-block">Login</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import User from "../../config/User";
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      loading:false,
      form: {
        email: "",
        password: ""
      },
      errors: []
    };
    
  },
 computed: {
    ...mapGetters(["isLoggedIn"])
  },
  methods: {
    login() {
      User.login(this.form)
        .then(response => {
          this.$store.commit("LOGIN", true);
          localStorage.setItem("token", response.data);
          this.$router.push('/home');
          window.location.href = '/'
        })
        .catch(error => {
          if (error.response.status === 422) {
            this.errors = error.response.data.errors;
          }
        });
    }
  }
};
</script>
