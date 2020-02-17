class BarattoApiClient {
  async login(email, password) {
    let options = {
      method: 'POST',
      body: JSON.stringify({
        "email": email,
        "password": password
      })
    };
    let response = await fetch('/api/auth/login', options);
    let data = await response.json();
    return data;
  }
}

export default BarattoApiClient;