<template>
  <div class="row">
    <div class="col s12 m6">
      <div class="card">
        <div class="card-content">
          <span class="card-title">Articoli</span>
          <div class="row">
            <form class="col s12">
              <ul id="example-1">
                <li v-for="articolo in articoli" v-bind:key="articolo">
                  {{ articolo.id }} - {{ articolo.nome }} - {{ articolo.monete }}
                  <span>                                  
                    <a class="waves-effect waves-light btn" @click="updateArticolo(articolo.id)">Modifica</a>
                    <a class="waves-effect waves-light btn" @click="deleteArticolo(articolo.id)">Elimina</a>
                  </span>>
                </li>
              </ul>
              <div>
                <span>Articolo</span>
                <div class="row">
                  <div class="input-field col s12">
                    <input id="nome" type="text" class="validate" v-model="nome">
                    <label for="nome">Nome</label>
                  </div>
                </div>
                <div class="row">
                  <div class="input-field col s12">
                    <input id="monete" type="number" class="validate" v-model="monete">
                    <label for="monete">Monete</label>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="card-action">
          <a class="waves-effect waves-light btn" @click="listArticoli()">Elenca</a>          
          <a class="waves-effect waves-light btn" @click="insertArticolo()">Inserisci</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import BarattoApiClient from "../lib/baratto-api-client";

const barattoApiClient = new BarattoApiClient();

export default {
  name: "Admin",
  data: () => ({
    articoli: [],
    nome: '',
    monete: 0
  }),
  mounted() {
    if (this.accessToken == '' || !this.allowAdmin) {
      this.$routes.push({ path: "/login" });
    }
  },
  methods: {
    async listArticoli() {      
      this.articoli = await barattoApiClient.listArticoli(this.accessToken);
      console.log(articoli);
    },
    async getArticolo(id) {            
      let articolo = await barattoApiClient.getArticolo(this.accessToken, id);
      console.log(articolo);
    },
    async insertArticolo() {      
      let articolo = {
        'nome': this.nome,
        'monete': this.monete
      };
      let articolo = await barattoApiClient.listArticoli(this.accessToken, articolo);      
      console.log(articolo);
      await this.listArticoli();
    },
    async updateArticolo(id) {                  
      let articolo = {
        'nome': this.nome,
        'monete': this.monete
      };
      let articolo = await barattoApiClient.listArticoli(this.accessToken, id, articolo);
      console.log(articolo);
      await this.listArticoli();
    },
    async deleteArticolo(id) {          
      await barattoApiClient.deleteArticolo(this.accessToken, id);      
      console.log('deleted');
      await this.listArticoli();
    }
  },
  computed: {
    ...mapState('counter', {
      accessToken: state => state.accessToken,
      allowAdmin: state => state.allowAdmin
    })
  }
};
</script>
