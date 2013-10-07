<div class="margined">
    <h1>Our API</h1>
    <p>Since we created the software with a strong backend, we're able to easily gather data for usage by programs that want it.</p>
    <p>We currently support <code>GET</code> requests that return <code>JSON</code> data.</p>
    <hr/>
    <p>To access the api, send a GET request with the intended parameters to /_api/&lt;filename&gt;.php.</p>
    <p>For example, to access the <code>search</code> page with the parameter <code>q</code>, send a request to <code>http://shellfish.io/_api/search.php?q=your+query</code>.</p>
    <div class="margined group-sample">
        <h4 id="pg-search">Search</h4>
        <p>This will search the site for tutorials and return the first result. Searching uses tags and categories, and prioritizes them as such.</p>
        <p>File: <code>/_api/search.php</code></p>
        <p>Parameters: <ul>
            <li><code>q</code>: Your Search Query.</li>
        </ul>
        <p><a href="/_api/search.php?q=tutorials">Example</a></p>
        <p>Data Structure: <a href="#ds-tutorial">Tutorial</a></p>
    </div>
    <br/>
    <div class="margined group-sample">
        <h4 id="pg-data">Data</h4>
        <p>This will simply return all the data for a certain tutorial.</p>
        <p>File: <code>/_api/data.php</code></p>
        <p>Parameters: <ul>
            <li><code>id</code>: The id of the tutorial.</li>
        </ul>
        <p><a href="/_api/data.php?id=0">Example</a></p>
        <p>Data Structure: <a href="#ds-tutorial">Tutorial</a></p>
    </div>
    <br/>
    <div class="margined group-sample">
        <h4 id="pg-recent">Recent</h4>
        <p>This will return the most recent tutorial created.</p>
        <p>File: <code>/_api/recent.php</code></p>
        <p>Parameters: <ul>
            <li>None are needed.</li>
        </ul>
        <p><a href="/_api/recent.php">Example</a></p>
        <p>Data Structure: <a href="#ds-tutorial">Tutorial</a></p>
    </div>
    <br/>
    <div class="margined group-sample">
        <h4 id="pg-popular">Popular</h4>
        <p>This will return the most popular tutorial, by views.</p>
        <p>File: <code>/_api/popular.php</code></p>
        <p>Parameters: <ul>
            <li>None are needed.</li>
        </ul>
        <p><a href="/_api/popular.php">Example</a></p>
        <p>Data Structure: <a href="#ds-tutorial">Tutorial</a></p>
    </div>
    <br/>
    <div class="margined group-sample">
        <h4 id="pg-random">Raindom</h4>
        <p>This will return a random tutorial.</p>
        <p>File: <code>/_api/random.php</code></p>
        <p>Parameters: <ul>
            <li>None are needed.</li>
        </ul>
        <p><a href="/_api/random.php">Example</a></p>
        <p>Data Structure: <a href="#ds-tutorial">Tutorial</a></p>
    </div>
    <hr/>
    <h2>JSON data</h2>
    <h3 id="ds-error">Errors</h3>
    <p>First, check if you've run into an error. Errors are conveyed by a "success" key in the JSON data returned.</p>
    <pre data-language="javascript">
{
    "success": 0,
    "message": "No tutorials were found matching your terms."
}
    </pre>
    <p>If success is equal to 0, you have run into an error and the "message" will tell you what it is.</p>
    <p>If success is equal to 1, you have successfully fetched data.</p>
    <h3>Data Models</h3>
    <p>Comments are signified by a double-slash <code>//</code>.</p>
    <div class="margined group-sample">
        <h4 id="ds-tutorial">Tutorial</h4>
        <p>Currently, our only model is a Tutorial. This returns all the data we have about a certain tutorial.</p>
        <pre data-language="javascript">
{
    "success": 1,
    "data":{
        "id": "0",
        "title": "The title of the tutorial",
        "description": "A small description of the tutorial",
        "tags": [ "tagname", "moretags", "blah", "blahblah" ],
        "category": "theMainCategory",
        "title-slug": "a-tutorial-title-with-no-special-characters-for-the-link",
        "username": "author",
        "download": "The Downloadable File, if there is one",
        "text": "The text of the actual tutorial."
    }
}
        </pre>
    </div>
    <h3>Any other neat things I should know about?</h3>
    <p>Sure!</p>
    <ul>
        <li>You can use a shortened link using <code>/_r/pageid/</code>, it redirects to the longer link with the slug.</li>
        <li>Links are in the form of <code>/tutorial/id/your-tutorial-slug/</code>, however, the slug can be anything, and you will still see the correct tutorial.</li>
        <li>You can contribute using the <a href="http://github.com/pufferfi-sh/Shellfish/">GitHub link</a> if you want to. :-)</li>
        <li>Got any questions? Suggestions? Ideas? Come stop by and say hello in our <a href="/irc/">IRC channel</a>!</li>
    </ul>
</div>
