@extends('layouts.noNavBar')

@section('pageTitle', 'Create Character')

@section('content')

<div class="container justify-content-center my-3">
    <div class="create_character row mx-2">
        <div class="col-md-2 mb-3"></div>
        <div class="character_information col-md-8 mb-3">
            <form class="text-left" method="POST" action="/register">
                {{ csrf_field() }}
                <div class="text-center">
                    <img class="rounded w-15" src="{{ asset('assets/logo.png') }}" alt="icon">
                </div>
                <h3 class="text-center mt-5 mb-5">Please answer the following questions to generate your character</h3>
                <div class="form-group mx-auto">
                    <label for="character_name">Character Name</label>
                    <input type="text" name="char_name" class="form-control" id="character_name" placeholder="Name" required>
                    <label class="mt-2" for="birthdate">Birth</label>
                    <input type="date" name="birthday" class="form-control" id="birthdate" value="2009-01-09" required>
                </div>
                <br><br>
                <div class="personality row justify-content-center">
                    <div class="personality_questions align-self-center">
                        <div class="row align-self-center">
                            <div class="col-md-4 form-group">
                                <label>Do you get angry very easily?</label><br>
                                <label><input type="radio" name="angriness" value="Fighter" required> Oh Yeah!</label><br>
                                <label><input type="radio" name="angriness" value="Wizard"> Some Times</label><br>
                                <label><input type="radio" name="angriness" value="Rogue"> Rarely</label><br>
                                <label><input type="radio" name="angriness" value="Healer"> Never</label><br>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Do you experience your emotions intensely?</label><br>
                                <label><input type="radio" name="emotional" value="Female" required> Yes</label><br>
                                <label><input type="radio" name="emotional" value="Male"> No</label><br>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Do you see yourself as an introvert or extrovert?</label><br>
                                <label><input type="radio" name="outness" value="Female" required> Introvert</label><br>
                                <label><input type="radio" name="outness" value="Male"> Extrovert</label><br>
                            </div>
                        </div>
                        <div class="row align-self-center">
                            <div class="col-md-4 form-group">
                                <label>Do you make friends easily?</label><br>
                                <label><input type="radio" name="happiness" value="Dwarf" required> For Sure!</label><br>
                                <label><input type="radio" name="happiness" value="Human"> Sort of</label><br>
                                <label><input type="radio" name="happiness" value="Elf"> I have trouble</label><br>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Choose the one that best describes you?</label><br>
                                <label><input type="radio" name="best" value="Fighter" required> Risk Taker</label><br>
                                <label><input type="radio" name="best" value="Wizard"> Lazy</label><br>
                                <label><input type="radio" name="best" value="Healer"> Loyal</label><br>
                                <label><input type="radio" name="best" value="Rogue"> Overlooked</label><br>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="text" name="name" value="{{$data['name']}}" hidden>
                <input type="text" name="email" value="{{$data['email']}}" hidden>
                <input type="text" name="password" value="{{$data['password']}}" hidden>
                <div class="mx-auto mt-5">
                    <button type="submit" class="btn btn-secondary w-100">Generate my Character</button>
                </div>
            </form>    
        </div>    
    </div>
    <div class="col-md-2 mb-3"></div>
</div>
@endsection