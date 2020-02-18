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

}

export default BarattoApiClient;