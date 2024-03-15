<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            Signup
          </div>
          <div class="card-body">
            <form action="http://localhost/api/auth/signup" method="POST">
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
              </div>
              <br>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <br>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <br>
              <br>
              <button type="submit" class="btn btn-primary">Signup</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
