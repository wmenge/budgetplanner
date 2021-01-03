<div class="row">

  <div class="col-sm-3"></div>

  <div class="col-sm-6">

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
        <h3>Login</h3>
      
      <form action="/oauth2/github/login" style="display: inline-block;">
        <input type="hidden" value="<?= @$referer ?>" name="referer">
        <div class="form-group">
                <label>Login with:</label>
        </div>
        <button type="submit" class="btn btn-primary btn-lg">GitHub</button>
      </form>
      <label>or</label>

      <form action="/oauth2/google/login" style="display: inline-block;">
        <input type="hidden" value="<?= @$referer ?>" name="referer">
        <button type="submit" class="btn btn-primary btn-lg">Google</button>
      </form>

    </div>

  </div>

  <div class="col-sm-3"></div>

</div>