


    <div class="jumbotron">
        <form method="post" action="">


            <div class="row">
                <div class="col-md-6">
                    <label for="pseudo">Pseudo : </label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div><input class="form-control" type="text" name="pseudo" placeholder="Votre pseudo" id="pseudo">
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="mdp">Mot de passe : </label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div><input class="form-control" type="password" name="mdp" id="mdp" placeholder="Votre mot de passe">
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-6">
                    <label for="nom">Nom: </label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></div><input class="form-control" type="text" name="nom" id="nom" placeholder="Votre nom">
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="prenom">Prénom: </label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></div><input class="form-control" type="text" name="prenom" id="prenom" placeholder="Votre prenom">
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label for="telephone">Téléphone : </label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-phone-alt"></span></div><input class="form-control" type="tel" name="telephone" id="telephone" placeholder="Votre téléphone">
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="mdp">Email: </label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div><input class="form-control" type="email" name="email" id="email" placeholder="Votre email">
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-6">
                    <label for="civilite">Civilite :</label>
                    <select class="form-control">
                        <option value="monsieur">Monsieur</option>
                        <option value="Madame">Madame</option>
                        <option value="Mademoiselle">Mademoiselle</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="statut">Statut :</label>
                    <select class="form-control">
                        <option value="admin">Admin</option>
                        <option value="membre">Membre</option>   
                    </select>
                </div>
            </div><br>
            <input type="submit" name="inscriSubmit"  id="inscriSubmit" class="btn btn-info" value="S'inscrire">

        </form>
    </div>
</div>