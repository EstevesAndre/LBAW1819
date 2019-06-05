@extends('layouts.noNavBar')

@section('content')

<div class="container justify-content-center my-5">
    
    <div class="create_character row mx-2">
        <div class="col-md-2 mb-3"></div>
        <div class="character_information col-md-8 mb-3">
        <form class="text-left" method="POST" action="/register">
                <div class="form-group mx-auto mb-5">
                    <label for="character_name">Character Name</label>
                    <input type="character_name" class="form-control" id="character_name" placeholder="Name">
                    <label for="birthdate">Birth</label>
                    <input type="date" class="form-control" id="birthdate" value="2009-01-09">
                </div>
                <h3 class="text-center">Please answer the following questions to generate your character</h3>
                <br><br>
                <div class="personality row justify-content-center">
                    <div class="personality_questions align-self-center">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="rather">Do you get angry very easily?</label><br>
                                <input type="radio" name="angriness" value="Fighter"> Oh Yeah!<br>
                                <input type="radio" name="angriness" value="Wizard"> Some Times<br>
                                <input type="radio" name="angriness" value="Rogue"> Rarely<br>
                                <input type="radio" name="angriness" value="Healer"> Never<br>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="rather">Do you experience your emotions intensely?</label><br>
                                <input type="radio" name="emotional" value="Female"> Yes<br>
                                <input type="radio" name="emotional" value="Male"> No<br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="rather">Do you see yourself as an introvert or extrovert?</label><br>
                                <input type="radio" name="emotional" value="Female"> Introvert<br>
                                <input type="radio" name="emotional" value="Male"> Extrovert<br>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="rather">Do you make friends easily?</label><br>
                                <input type="radio" name="happiness" value="Dwarf"> For Sure!<br>
                                <input type="radio" name="happiness" value="Human"> Sort of<br>
                                <input type="radio" name="happiness" value="Elf"> I have trouble<br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6 form-group">
                                <label for="rather">Choose the one that best describes you?</label><br>
                                <input type="radio" name="best" value="Fighter"> Risk Taker<br>
                                <input type="radio" name="best" value="Wizard"> Lazyness<br>
                                <input type="radio" name="best" value="Healer"> Loyal<br>
                                <input type="radio" name="best" value="Rogue"> Overlooked<br>
                            </div>
                            <div class="col-md-3"></div>
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
        <div class="col-md-2 mb-3"></div>
    </div>
</div>
@endsection