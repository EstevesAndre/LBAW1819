@extends('layouts.noNavBar')

@section('content')
<br />
<br />
<div class="container justify-content-center my-5">
    <div class="create_character row mx-2">
        <div class="character_information col-md-8 mb-3">
            <form class="text-left">
                <div class="form-group mx-auto mb-5">
                    <label for="character_name">Character Name</label>
                    <input type="character_name" class="form-control" id="character_name" placeholder="Name">
                    <label for="birthdate">Birth</label>
                    <input type="date" class="form-control" id="birthdate" value="2009-01-09">
                </div>
                <div class="personality row justify-content-center">
                    <div class="personality_control col-md-5 align-self-center">
                        <div class="form-group">
                            <label for="strength">Strength</label>
                            <input type="range" class="custom-range" min="0" max="5" id="strength">
                        </div>
                        <div class="form-group">
                            <label for="intelligence">Intelligence</label>
                            <input type="range" class="custom-range" min="0" max="5" id="intelligence">
                        </div>
                        <div class="form-group">
                            <label for="hapiness">Hapiness</label>
                            <input type="range" class="custom-range" min="0" max="5" id="hapiness">
                        </div>
                        <div class="form-group">
                            <label for="hapiness">Shininess</label>
                            <input type="range" class="custom-range" min="0" max="5" id="hapiness">
                        </div>
                        <div class="form-group">
                            <label for="laziness">Laziness</label>
                            <input type="range" class="custom-range" min="0" max="5" id="laziness">
                        </div>
                        <div class="form-group">
                            <label for="hapiness">Anger</label>
                            <input type="range" class="custom-range" min="0" max="5" id="anger">
                        </div>
                    </div>
                    <div class="personality_questions col-md-5 align-self-center">
                        <div class="form-group">
                            <label for="rather">Question 1?</label>
                            <select class="form-control" id="rather">
                                <option>Answer 1</option>
                                <option>Answer 2</option>
                                <option>Answer 3</option>
                                <option>Answer 4</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="rather">Question 2?</label>
                            <select class="form-control" id="rather">
                                <option>Answer 1</option>
                                <option>Answer 2</option>
                                <option>Answer 3</option>
                                <option>Answer 4</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="rather">Question 3?</label>
                            <select class="form-control" id="rather">
                                <option>Answer 1</option>
                                <option>Answer 2</option>
                                <option>Answer 3</option>
                                <option>Answer 4</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="rather">Question 4?</label>
                            <select class="form-control" id="rather">
                                <option>Answer 1</option>
                                <option>Answer 2</option>
                                <option>Answer 3</option>
                                <option>Answer 4</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="rather">Question 5?</label>
                            <select class="form-control" id="rather">
                                <option>Answer 1</option>
                                <option>Answer 2</option>
                                    <option>Answer 3</option>
                                    <option>Answer 4</option>
                                </select>
                        </div>
                    </div>
                </div>
                <div class="mx-auto mt-5">
                    <button type="submit" class="btn btn-secondary w-100">Generate</button>
                </div>
            </form>
        </div>
        <div class="character_preview col-md align-self-center mt-4">
            <div class="card">
                <img src="../assets/logo.png" class="card-img-top border-bottom" alt="avatar"> 
                <div class="card-body mt-3 mb-3">
                    <div><i class="fas fa-user"></i> Name : Name</div>
                    <div><i class="fas fa-flag"></i> Race: Dwarf</div>
                    <div><i class="fas fa-clock"></i> Age: 99</div>
                    <div><i class="fas fa-cloud-sun"></i> Season: Winter</div>
                </div>
                <a href="../pages/profile.html" class="btn btn-dark">Create Character</a>
            </div>
        </div>

    </div>
</div>
@endsection