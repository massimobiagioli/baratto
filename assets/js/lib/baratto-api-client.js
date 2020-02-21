class BarattoApiClient {
  
  async login(email, password) {
    let options = {
      method: 'POST',
      body: JSON.stringify({
        "email": email,
        "password": password
      })
    };
    try {
      let response = await fetch('/api/auth/login', options);
      let data = await response.json();
      return data;
    } catch (err) {
      return null;
    }
  }
  
  async logout(authToken) {    
    try {
      let response = await fetch(`/api/auth/logout?accessToken=${authToken}`);
      let data = await response.json();      
    } catch (err) {
      return null;
    }
  }

  async listArticoli(authToken) {
    let headers = new Headers();
    headers.append('X-AUTH-TOKEN', authToken);
    let options = {
      method: 'GET',
      headers
    };
    try {
      let response = await fetch('/api/admin/articoli', options);
      let data = await response.json();
      return data;
    } catch (err) {
      return null;
    }
  }

  async getArticolo(authToken, id) {
    let headers = new Headers();
    headers.append('X-AUTH-TOKEN', authToken);
    let options = {
      method: 'GET',
      headers
    };
    try {
      let response = await fetch(`/api/admin/articoli/${id}`, options);
      let data = await response.json();
      return data;
    } catch (err) {
      return null;
    }
  }

  async insertArticolo(authToken, articolo) {
    let headers = new Headers();
    headers.append('X-AUTH-TOKEN', authToken);
    let options = {
      method: 'POST',
      headers,
      body: JSON.stringify(articolo)
    };
    try {
      let response = await fetch('/api/admin/articoli', options);
      let data = await response.json();
      return data;
    } catch (err) {
      return null;
    }
  }

  async updateArticolo(authToken, id, articolo) {
    let headers = new Headers();
    headers.append('X-AUTH-TOKEN', authToken);
    let options = {
      method: 'PUT',
      headers,
      body: JSON.stringify(articolo)
    };
    try {
      let response = await fetch(`/api/admin/articoli/${id}`, options);
      let data = await response.json();
      return data;
    } catch (err) {
      return null;
    }
  }

  async deleteArticolo(authToken, id) {
    let headers = new Headers();
    headers.append('X-AUTH-TOKEN', authToken);
    let options = {
      method: 'DELETE',
      headers
    };
    try {
      let response = await fetch(`/api/admin/articoli/${id}`, options);
      let data = await response.json();
      return data;
    } catch (err) {
      return null;
    }
  }

  async sell(authToken, articoloId, quantita) {
    let headers = new Headers();
    headers.append('X-AUTH-TOKEN', authToken);
    let options = {
      method: 'POST',
      headers,
      body: JSON.stringify({
        articoloId,
        quantita
      })
    };
    try {
      let response = await fetch('/api/sell', options);
      let data = await response.json();
      return data;
    } catch (err) {
      return null;
    }
  }

  async buy(authToken, movimentoId) {
    let headers = new Headers();
    headers.append('X-AUTH-TOKEN', authToken);
    let options = {
      method: 'POST',
      headers,
      body: {
        movimentoId
      }
    };
    try {
      let response = await fetch('/api/buy', options);
      let data = await response.json();
      return data.ticket;
    } catch (err) {
      return null;
    }
  }

  async close(authToken, movimentoId) {
    let headers = new Headers();
    headers.append('X-AUTH-TOKEN', authToken);
    let options = {
      method: 'POST',
      headers,
      body: {
        movimentoId
      }
    };
    try {
      let response = await fetch('/api/close', options);
      let data = await response.json();
      return data;
    } catch (err) {
      return null;
    }
  }

  async listItemsForSale(authToken) {
    let headers = new Headers();
    headers.append('X-AUTH-TOKEN', authToken);
    let options = {
      method: 'GET',
      headers
    };
    try {
      let response = await fetch('/api/listItemsForSale', options);
      let data = await response.json();
      return data;
    } catch (err) {
      return null;
    }
  }

  async listItemsToBuy(authToken) {
    let headers = new Headers();
    headers.append('X-AUTH-TOKEN', authToken);
    let options = {
      method: 'GET',
      headers
    };
    try {
      let response = await fetch('/api/listItemsToBuy', options);
      let data = await response.json();
      return data;
    } catch (err) {
      return null;
    }
  }

  async listItemsPurchased(authToken) {
    let headers = new Headers();
    headers.append('X-AUTH-TOKEN', authToken);
    let options = {
      method: 'GET',
      headers
    };
    try {
      let response = await fetch('/api/listItemsPurchased', options);
      let data = await response.json();
      return data;
    } catch (err) {
      return null;
    }
  }

  async listItemsToClose(authToken) {
    let headers = new Headers();
    headers.append('X-AUTH-TOKEN', authToken);
    let options = {
      method: 'GET',
      headers
    };
    try {
      let response = await fetch('/api/listItemsToClose', options);
      let data = await response.json();
      return data;
    } catch (err) {
      return null;
    }
  }

  async residualCoins(authToken) {
    let headers = new Headers();
    headers.append('X-AUTH-TOKEN', authToken);
    let options = {
      method: 'GET',
      headers
    };
    try {
      let response = await fetch('/api/residualCoins', options);
      let data = await response.json();
      return data.residualCoins;
    } catch (err) {
      return null;
    }
  }

}

export default BarattoApiClient;