<template>
  <div>

    <!-- Articoli in vendita -->
    <div class="row">
      <div class="col s12">
        <div class="card">
          <div class="card-content">
            <span class="card-title">ELENCO ARTICOLI IN VENDITA (Monete residue: {{residualCoins}})</span>            
            <ul id="articoli_vendita">
              <li v-for="movimento in movimenti" v-bind:key="movimento.id">
                <div class="row">
                  <div class="col s12">
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
      <div class="col s12">
        <div class="card">
          <div class="card-content">                        
              <span class="card-title">VENDITA ARTICOLO</span>            
              <div class="row">
                <form class="col s12">                                                                  
                  <div class="row">
                    <div class="input-field col s12">
                      <select id="artitolo-id" v-model="articoloId">
                        <option  v-for="articolo in articoli" :value="articolo.id" :key="articolo.id">
                          {{articolo.nome}}
                        </option>                    
                      </select>
                      <label for="articolo-id">Articolo</label>
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
          </div>
          <div class="card-action">
            <a class="waves-effect waves-light btn" @click="sell()">VENDI</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Articoli in vetrina -->
    <div class="row">
      <div class="col s12">
        <div class="card">
          <div class="card-content">            
            <span class="card-title">ELENCO ARTICOLI IN VETRINA</span> 
            <ul id="articoli_vetrina">
              <li v-for="articoloVetrina in articoliVetrina" v-bind:key="articoloVetrina.id">
                <div class="row">
                  <div class="col s12">
                    <span class="col s12">{{ articoloVetrina.articolo.nome }} - Qta: {{ articoloVetrina.quantita }}</span>
                    <span class="col s12">Venduto da {{ articoloVetrina.venditore.nome }} {{ articoloVetrina.venditore.cognome }} -  Email:  {{ articoloVetrina.venditore.email }}</span>
                    <span class="col s12">Presente dal: {{ articoloVetrina.dataOperazione.date }}</span>
                    <span class="col s12">
                      <a class="waves-effect waves-light btn" @click="buy(articoloVetrina.id)">Compra</a>
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
      <div class="col s12">
        <div class="card">
          <div class="card-content">
            <span class="card-title">ELENCO ARTICOLI ACQUISTATI</span>
            <ul id="articoli_acquistati">
              <li v-for="articoloAcquistato in articoliAcquistati" v-bind:key="articoloAcquistato.id">
                <div class="row">
                  <div class="col s12">
                    <span class="col s12">{{ articoloAcquistato.articolo.nome }} - {{ articoloAcquistato.dataOperazione.date }} - Qta: {{ articoloAcquistato.quantita }}</span>
                    <span class="col s12">Acquistato da {{ articoloAcquistato.venditore.nome }} {{ articoloAcquistato.venditore.cognome }} -  Email:  {{ articoloAcquistato.venditore.email }}</span>
                    <span class="col s12">Ticket: <b>{{ articoloAcquistato.ticket }}</b></span>
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
    
    <!-- I miei ticket -->
    <div class="row">
      <div class="col s12">
        <div class="card">
          <div class="card-content">
            <span class="card-title">I MIEI TICKET</span>
            <ul id="articoli_acquistati">
              <li v-for="articoloDaEvadere in articoliDaEvadere" v-bind:key="articoloDaEvadere.id">
                <div class="row">
                  <div class="col s12">
                    <span class="col s12">{{ articoloDaEvadere.articolo.nome }} - {{ articoloDaEvadere.dataOperazione.date }} - Qta: {{ articoloDaEvadere.quantita }}</span>
                    <span class="col s12">Acquistato da {{ articoloDaEvadere.compratore.nome }} {{ articoloDaEvadere.compratore.cognome }} -  Email:  {{ articoloDaEvadere.compratore.email }}</span>
                    <span v>Ticket: <b>{{ articoloDaEvadere.ticket }}</b></span>
                    <span class="col s12">
                      <a class="waves-effect waves-light btn" @click="close(articoloDaEvadere.id)">Evadi</a>
                    </span>
                  </div>
                </div>
              </li>
            </ul>
          </div>
          <div class="card-action">
            <a class="waves-effect waves-light btn" @click="listItemsToClose()">Aggiorna elenco</a>            
          </div>
        </div>
      </div>
    </div>

    <div class="col s12">
      <a class="waves-effect waves-light btn" @click="logout({accessToken})">Logout</a>
    </div>

  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import BarattoApiClient from "../lib/baratto-api-client";

const barattoApiClient = new BarattoApiClient();

export default {
  name: "User",
  data: () => ({
    residualCoins: 0,
    quantita: 0,
    articoloId: 0,
    movimenti: [],
    articoliVetrina: [],
    articoliAcquistati: [],
    articoliDaEvadere: [],
    articoli: []
  }),
  async mounted() {
    if (this.accessToken == '') {
      this.$router.push({ path: "/login" });
      return;
    }
    await this.listArticoli();
    this.initMaterialWidgets();
    await this.refreshAll();
  },
  methods: {
    ...mapActions('auth', [
      'logout'
    ]),
    initMaterialWidgets() {
      let options = {};
      let elems = document.querySelectorAll('select');
      let instances = M.FormSelect.init(elems, options);
    },
    async listItemsForSale() {      
      this.movimenti = await barattoApiClient.listItemsForSale(this.accessToken);
    },
    async listItemsToBuy() {      
      this.articoliVetrina = await barattoApiClient.listItemsToBuy(this.accessToken);
    },
    async listItemsPurchased() {      
      this.articoliAcquistati = await barattoApiClient.listItemsPurchased(this.accessToken);
    },
    async listItemsToClose() {      
      this.articoliDaEvadere = await barattoApiClient.listItemsToClose(this.accessToken);
    },
    async refreshResidualCoins() {      
      this.residualCoins = await barattoApiClient.residualCoins(this.accessToken);
    },
    async listArticoli() {      
      this.articoli = await barattoApiClient.listArticoli(this.accessToken);
    },
    async sell() {      
      await barattoApiClient.sell(this.accessToken, this.articoloId, this.quantita);
      await this.refreshAll();      
    },
    async buy(movimentoId) {      
      await barattoApiClient.buy(this.accessToken, movimentoId);
      await this.refreshAll();      
    },
    async close(movimentoId) {      
      await barattoApiClient.close(this.accessToken, movimentoId);
      await this.refreshAll();      
    },
    async refreshAll() {      
      await this.refreshResidualCoins();
      await this.listItemsToBuy();
      await this.listItemsForSale();
      await this.listItemsPurchased();
      await this.listItemsToClose();
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
