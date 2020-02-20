<template>
  <div>

    <!-- Articoli in vendita -->
    <div class="row">
      <div class="col s12 m6">
        <div class="card">
          <div class="card-content">
            ELENCO ARTICOLI IN VENDITA (Monete residue: {{residualCoins}})

            <ul id="articoli_vendita">
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
            <a class="waves-effect waves-light btn" @click="listItemsForSale()">Aggiorna elenco</a>
            <a class="waves-effect waves-light btn" @click="refreshResidualCoins()">Aggiorna monete residue</a>  
          </div>
        </div>
      </div>
    </div>

    <!-- Vendita  articolo -->
    <div class="row">
      <div class="col s12 m6">
        <div class="card">
          <div class="card-content">
            VENDITA ARTICOLO

            <form class="col s12 m6">                            
              <div class="row">
                <div class="input-field col s12">
                  <select v-model="articoloId">
                    <option v-for="articolo in articoli" :value="articolo" :key="articolo.id">
                      {{articolo.nome}}
                    </option>
                  </select>
                  <label for="nome">Articolo</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="quantita" type="number" class="validate" v-model="quantita">
                  <label for="quantita">Quantita</label>
                </div>
              </div>              
            </form>

          </div>
          <div class="card-action">
            <a class="waves-effect waves-light btn" @click="sell()">VENDI</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Articoli in vetrina -->
    <div class="row">
      <div class="col s12 m6">
        <div class="card">
          <div class="card-content">
            ELENCO ARTICOLI IN VETRINA

            <ul id="articoli_vetrina">
              <li v-for="articoloVetrina in articoliVetrina" v-bind:key="articoloVetrina.id">
                <div class="row">
                  <div class="col s6 m6">
                    <span>{{ articoloVetrina.articolo.nome }} - {{ articoloVetrina.dataOperazione.date }} - Qta: {{ articoloVetrina.quantita }}</span>
                    <span>Venduto da {{ articoloVetrina.venditore.nome }} {{ articoloVetrina.venditore.cognome }} -  Qta:  {{ articoloVetrina.venditore.email }}</span>
                    <span>
                      <a class="waves-effect waves-light btn" @click="buy(articoliVetrina.id)">Compra</a>
                    </span>
                  </div>
                </div>
              </li>
            </ul>

          </div>
          <div class="card-action">
            <a class="waves-effect waves-light btn" @click="listItemsToBuy()">Aggiorna elenco</a>            
          </div>
        </div>
      </div>
    </div>

     <!-- Articoli acquistati -->
    <div class="row">
      <div class="col s12 m6">
        <div class="card">
          <div class="card-content">
            ELENCO ARTICOLI ACQUISTATI

            <ul id="articoli_acquistati">
              <li v-for="articoloAcquistato in articoliAcquistati" v-bind:key="articoloAcquistato.id">
                <div class="row">
                  <div class="col s6 m6">
                    <span>{{ articoloAcquistato.articolo.nome }} - {{ articoloAcquistato.dataOperazione.date }} - Qta: {{ articoloAcquistato.quantita }}</span>
                    <span>Acquistato da {{ articoloAcquistato.venditore.nome }} {{ articoloAcquistato.venditore.cognome }} -  Qta:  {{ articoloAcquistato.venditore.email }}</span>
                    <span>Ticket: <b>{{ articoloAcquistato.ticket }}</b></span>
                  </div>
                </div>
              </li>
            </ul>

          </div>
          <div class="card-action">
            <a class="waves-effect waves-light btn" @click="listItemsPurchased()">Aggiorna elenco</a>            
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
    quantita,
    articoloId,
    movimenti: [],
    articoliVetrina: [],
    articoliAcquistati: [],
    articoli: []
  }),
  async mounted() {
    if (this.accessToken == '') {
      this.$router.push({ path: "/login" });
    }
    await refreshAll();
  },
  methods: {
    async listItemsForSale() {      
      this.movimenti = await barattoApiClient.listItemsForSale(this.accessToken);
    },
    async listItemsToBuy() {      
      this.articoliVetrina = await barattoApiClient.listItemsToBuy(this.accessToken);
    },
    async listItemsPurchased() {      
      this.articoliAcquistati = await barattoApiClient.listItemsToBuy(this.accessToken);
    },
    async refreshResidualCoins() {      
      this.residualCoins = await barattoApiClient.residualCoins(this.accessToken);
    },
    async listArticoli() {      
      this.articoli = await barattoApiClient.listArticoli(this.accessToken);
    },
    async sell() {      
      await barattoApiClient.sell(this.accessToken, this.articoloId, this.quantita);
      await refreshAll();      
    },
    async buy(movimentoId) {      
      await barattoApiClient.buy(this.accessToken, this.movimentoId, this.articoloId);
      await refreshAll();      
    },
    async refreshAll() {
      await this.listArticoli();
      await this.refreshResidualCoins();
      await this.listItemsToBuy();
      await this.listItemsForSale();
      await this.listItemsPurchased();
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
