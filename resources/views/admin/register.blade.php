<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <title>Opticien Login</title>
</head>
<style>
        

    body{
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        background: #FCFCFC;
    }

    form{
        width: 500px;
        padding: 40px;
        border-left: 5px solid rgb(58, 135, 250);
        border-right: 5px solid rgb(58, 135, 250);
        box-shadow: rgba(0, 0, 0, 0.15) 2.4px 2.4px 3.2px;
        background: white;
    }
    input{
        width: 100%;
    }
    label{
        margin-bottom: 10px;
    }
    .title1{
        font-size: 24px;
        height: 60px;
        width: 80px;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
    }
    .title2{
        font-size: 24px;
        height: 60px;
        width: 100%;
        display: flex;
        padding: 10px;
        align-items: center;
        background: white;
        font-weight: 600;
        border-top: 5px solid rgb(58, 135, 250);
        border-right: 5px solid rgb(58, 135, 250);
    }

    h5{
        text-align: left
    }
</style>
<body>
    <Section>
        <div class="container">
            <div class="d-flex">
                <div class="title1 bg-primary">
                    <h5>Optic</h5>
                 </div>
                <div class="title2">
                  <h5 class="text-primary">House</h5>
                 </div>
            </div>
            <form action="{{route('admin.store')}}" method="POST" class="vstack gap-3">
                @csrf
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" class="form-control @error('nom') is-invalid @enderror " placeholder="Adresse email">
                    @error('nom')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="prenom">Prenom</label>
                    <input type="text" id="prenom" name="prenom" class="form-control @error('prenom') is-invalid @enderror " placeholder="Adresse email">
                    @error('prenom')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror " placeholder="Adresse email">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Mot de passe</label>
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror " placeholder="Mot de passe">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirmation du mot de passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password') is-invalid @enderror " placeholder="Mot de passe">
                    @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button class="btn btn-primary flex-grow-0 mt-3">Se connecter</button>
            </form>
        </div>
    </Section>
</body>

</html>
