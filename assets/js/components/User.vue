<template>
  <div>

    <div class="row">
      <div class="col s12 m6">
        <div class="card">
          <div class="card-content">
            Elenco articoli in vendita (Monete residue: {{residualCoins}})

            <ul id="example-1">
              <li v-for="movimento in movimenti" v-bind:key="movimento.id">
                <div class="row">
                  <div class="col s6 m6">
                    <span>{{ movimento.articolo.nome }} - {{ movimento.dataOperazione.date }} - Qta: {{ movimento.quantita }}</span>
                  </div>
                </div>
              </li>
            </ul>

          </div>
          <div class="card-action">
            <a class="waves-effect waves-light btn" @click="listItemsForSale()">Elenca</a>
            <a class="waves-effect waves-light btn" @click="refreshResidualCoins()">Refresh Monete Residue</a>  
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col s12 m6">
        <div class="card">
          <div class="card-content">
            VENDITA ARTICOLO
          </div>
          <div class="card-action">
            
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import { mapState } from 'vuex';
import BarattoApiClient from "../lib/baratto-api-client";

const barattoApiClient = new BarattoApiClient();

export default {
  name: "User",
  data: () => ({
    residualCoins: 0,
    movimenti: []
  }),
  mounted() {
    if (this.accessToken == '') {
      this.$router.push({ path: "/login" });
    }
  },
  methods: {
    async listItemsForSale() {      
      this.movimenti = await barattoApiClient.listItemsForSale(this.accessToken);
    },
    async refreshResidualCoins() {      
      this.residualCoins = await barattoApiClient.residualCoins(this.accessToken);
    }
  },
  computed: {
    ...mapState('auth', {
      accessToken: state => state.accessToken,
      allowAdmin: state => state.allowAdmin
    })
  }
};
</script>
