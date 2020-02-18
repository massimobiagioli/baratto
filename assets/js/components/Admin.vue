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
                </li>
              </ul>
            </form>
          </div>
        </div>
        <div class="card-action">
          <a class="waves-effect waves-light btn" @click="listArticoli()">Elenca</a>
          <a class="waves-effect waves-light btn" @click="getArticolo()">GET</a>
          <a class="waves-effect waves-light btn" @click="insertArticolo()">INSERT</a>
          <a class="waves-effect waves-light btn" @click="updateArticolo()">UPDATE</a>
          <a class="waves-effect waves-light btn" @click="deleteArticolo()">DELETE</a>
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
    articoli: []
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
    async getArticolo() {      
      let id = 1;
      let articolo = await barattoApiClient.getArticolo(this.accessToken, id);
      console.log(articolo);
    },
    async insertArticolo() {      
      let articolo = {
        'nome': 'Articolo di prova',
        'monete': '15'
      };
      let articolo = await barattoApiClient.listArticoli(this.accessToken, articolo);
      console.log(articolo);
    },
    async updateArticolo() {            
      let id = 5;
      let articolo = {
        'nome': 'Articolo di prova modificato',
        'monete': '16'
      };
      let articolo = await barattoApiClient.listArticoli(this.accessToken, id, articolo);
      console.log(articolo);
    },
    async deleteArticolo() {    
      let id = 5;  
      await barattoApiClient.deleteArticolo(this.accessToken, id);      
      console.log('deleted');
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
