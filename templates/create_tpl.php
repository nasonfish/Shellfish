<form method="post" action="/create_submit.php">
    <!--<label for="username">Enter your username</label>
    <input id="username" name="username" type="text" value="<?//=$username?>"/>-->
    <label for="title">Enter a title</label>
    <input id="title" name="title" type="text" placeholder="How to..."/>
    <label for="description">Enter a description/subtitle</label>
    <input id="description" name="description" type="text" placeholder="A quick tutorial covering..."/>
    <label for="text">Create your tutorial!</label>
    <textarea id="text" name="text" placeholder="# First, we need to install..."></textarea>
    <label for="download">Optionally, you can create a downloadable script for the user.</label>
    <textarea id="download" name="download" placeholder="#!/bin/bash"></textarea>
    <label for="tags">Pick some tags so people can find your tutorial! (Separate with ', ')</label>
    <input id="tags" name="tags" type="text" placeholder="puppies, cheese, swords, ham"/>
    <!--<input id="ip" name="ip" value="<?//=$ip?>">--> <!-- hidden -->
    <br/>
    <button type="submit">Create!</button>
</form>