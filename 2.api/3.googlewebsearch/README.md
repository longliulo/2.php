https://developers.google.com/web-search/docs/#php-access
Developer's Guide

Audience

This documentation is designed for people familiar with Javascript programming and object-oriented programming concepts. There are many Javascript tutorials available on the Web

Introduction

The "Hello, World" of Google Web Search API

The easiest way to start learning about this API is to see a simple example. The following web page displays a collection of inline search results for a "VW GTI." The search results include Local, Web, Video, Blog, News, Image, Patent, and Book Search results.

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Hello World - Google  Web Search API Sample</title>
    <script src="https://www.google.com/jsapi"
        type="text/javascript"></script>
    <script language="Javascript" type="text/javascript">
    //<!
    google.load('search', '1');

    function OnLoad() {
      // Create a search control
      var searchControl = new google.search.SearchControl();

      // Add in a full set of searchers
      var localSearch = new google.search.LocalSearch();
      searchControl.addSearcher(localSearch);
      searchControl.addSearcher(new google.search.WebSearch());
      searchControl.addSearcher(new google.search.VideoSearch());
      searchControl.addSearcher(new google.search.BlogSearch());
      searchControl.addSearcher(new google.search.NewsSearch());
      searchControl.addSearcher(new google.search.ImageSearch());
      searchControl.addSearcher(new google.search.BookSearch());
      searchControl.addSearcher(new google.search.PatentSearch());

      // Set the Local Search center point
      localSearch.setCenterPoint("New York, NY");

      // tell the searcher to draw itself and tell it where to attach
      searchControl.draw(document.getElementById("searchcontrol"));

      // execute an inital search
      searchControl.execute("VW GTI");
    }
    google.setOnLoadCallback(OnLoad);

    //]]>
    </script>
  </head>
  <body>
    <div id="searchcontrol">Loading</div>
  </body>
</html>
To use the Web Search API within your web site, you will need to include the URL for the Google APIs loader (https://www.google.com/jsapi). This library allows you to load various APIs via google.load('api', 'version'). You can learn more here. Always be sure to include this library within a <script> tag before you attempt to use search control functionality.

The main object used by the Google Web Search API is an instance of SearchControl, which coordinates a search across a collection of search services, denoted as children of that object.

As you can see in the sample above, child objects of type LocalSearch, WebSearch, VideoSearch, BlogSearch, NewsSearch, ImageSearch, PatentSearch and BookSearch(experimental) are added to the search control using the addSearcher() method, and these searcher objects determine which search services the search control operates over.

The search control displays itself within the web page through a call to the SearchControl draw() method; this method also binds the search control onto your page (within the DOM). By default, a search control draws in a "linear" layout; you may also instruct the control to draw in a "tabbed" layout. These drawing modes will be discussed later.

In addition to tabbed layout options, the search control allows you to easily decouple the "search form" from the set of search results. One use of this is to have a search form in the sidebar of your page with results stacked in the center of the page.

A user initiates a search by entering search terms into the search control's text field followed by pressing the ENTER key or clicking on the search button to the right of the input field. The search control will automatically begin a parallel search across the requested Google services. You may also initiate a search programmatically by calling the search control's execute() method, passing an argument of search terms.

Using the Google API Loader

The Google Web Search API now is fully integrated with the Google API loader. The Google API loader specifies a common namespace scheme, to make it easier to use the different Google APIs together. Note that the old namespace scheme will continue to be supported, so that existing applications do not have to be updated.

Using the Google API loader is relatively simple. Changing your application to use the loader involves the following steps:

Instead of loading the Web Search API from http://www.google.com/uds, load the common loader from https://www.google.com/jsapi.
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
Load the Web Search API by using the google.load method as shown below. The google.load method takes an argument for the specific API and version number to load:
<script type="text/javascript">
  google.load("search", "1");
</script>
Use the google.search.* namespace for all classes, methods and properties you currently use in the Google Web Search API, replacing the G prefix with this namespace. For example, the GSearchControl object is mapped to google.search.SearchControl when using the Google API loader:
<html>
  <head>
    <script src="https://www.google.com/jsapi"
        type="text/javascript"></script>
    <script type="text/javascript">
      google.load("search", "1");

      // Call this function when the page has been loaded
      function initialize() {
        var searchControl = new google.search.SearchControl();
        searchControl.addSearcher(new google.search.WebSearch());
        searchControl.addSearcher(new google.search.NewsSearch());
        searchControl.draw(document.getElementById("searchcontrol"));
      }
      google.setOnLoadCallback(initialize);
    </script>

  </head>
  <body>
    <div id="searchcontrol"></div>
  </body>

</html>
Use google.setOnLoadCallback to register the specified handler function to be called once the document loads instead of GSearch.setOnLoadCallback.
The Web Search API has a few optional loader settings.
Dynamic loading - see the dynamic loading documentation.
Don't load CSS - if you don't want to load the default CSS then set "nocss" to true.
google.load("search", "1", {"nocss" : true});
Don't load old namespace - if you don't want the old namespace (GSearch, GSearchControl, etc...) then set "nooldnames" to true.
google.load("search", "1", {"nooldnames" : true});
Note: Most of the samples still use the old namespace so they will not work with this setting. This is only for custom applications that don't want their namespace to be cluttered with Google Web Search API.
Specific UI language - if you want to specify the language for the UI components (SearchControl, branding, etc...) instead of having it auto-detected then set "language" to the specific language code such as: en, es, zh-CN, pt-PT, and etc...
google.load("search", "1", {"language" : "en"});
Full documentation for using the Google API loader is available in the loader docs.

Browser Compatibility

The Google Web Search API currently supports Firefox 1.5+, IE 6, Safari, Opera 9+, and Chrome.

API Updates

The second argument within the google.load('search', '1.0'); contains the expected version level of this API (in this case version "1.0"). When we do a significant update to the API, we will "up" the version number and post a notice on the Web Search API discussion group. Take note of any required code changes when this occurs, and update your URLs to the new version when they are compliant.

After a new version is released, Google will support both old and new versions concurrently for a period of time, anticipated to be several months. After this period expires, client requests using the old API will no longer be accepted, so change your code as soon as you notice a new version.

The Google Web Search API team will also periodically update the API with recent bug fixes and performance enhancements without requiring a version update. For the most part, these fixes should remain transparent to you, but we may inadvertently break some API clients. Please use the Web Search API discussion group to report such issues.

Examples

Note: each of the following examples shows only relevant Javascript code, not a full HTML file. You can plug the code into the skeleton HTML file shown earlier, or you can download the full HTML file for each example by clicking the link after the example.

The Basics

The following example (identical to the Javascript code within the earlier Hello World code sample) creates a search control, configures it to search across Local Search, Web Search, Video Search, Blog Search, News Search, Image Search, Patant Search and Book Search (experimental), and then places the control on your page.

// create a search control
var searchControl = new google.search.SearchControl(null);

// add in a full set of searchers
searchControl.addSearcher(new google.search.LocalSearch());
searchControl.addSearcher(new google.search.WebSearch());
searchControl.addSearcher(new google.search.VideoSearch());
searchControl.addSearcher(new google.search.BlogSearch());
searchControl.addSearcher(new google.search.NewsSearch());
searchControl.addSearcher(new google.search.ImageSearch());
searchControl.addSearcher(new google.search.BookSearch());
searchControl.addSearcher(new google.search.PatentSearch());

// tell the searcher to draw itself and tell it where to attach
// Note that an element must exist within the HTML document with id "search_control"
searchControl.draw(document.getElementById("search_control"));
SearcherControl Draw Modes

The search control can be programmed to display in different draw modes. The google.search.DrawOptions object controls this behavior through its setDrawMode() method. This method takes the following arguments:

google.search.SearchControl.DRAW_MODE_LINEAR
google.search.SearchControl.DRAW_MODE_TABBED
To actually set the draw mode of a search control object, pass a google.search.DrawOptions object as a parameter to the search control's draw() method.
// create a drawOptions object
var drawOptions = new google.search.DrawOptions();

// tell the searcher to draw itself in linear mode
drawOptions.setDrawMode(google.search.SearchControl.DRAW_MODE_LINEAR);
searchControl.draw(element, drawOptions);
// tell the searcher to draw itself in tabbed mode
drawOptions.setDrawMode(google.search.SearchControl.DRAW_MODE_TABBED);
searchControl.draw(element, drawOptions);
Another common option available through this method is the ability to decouple the "search form" from the set of search results. The google.search.DrawOptions object controls this behavior through its setSearchFormRoot() method. This method accepts a DOM element which will act as the container for the search form.

// create a drawOptions object
var drawOptions = new google.search.DrawOptions();
drawOptions.setSearchFormRoot(document.getElementById("searchForm"));

searchControl.draw(element, drawOptions);
Searcher Objects

The addSearcher() method of the search control object determines which search services the search control operates. This method takes two arguments, one which specifies the service object, and a second argument specifying options for the service. The following searcher objects (services) are currently supported:

google.search.LocalSearch
google.search.WebSearch
google.search.VideoSearch
google.search.BlogSearch
google.search.NewsSearch
google.search.ImageSearch
google.search.BookSearch (experimental)
google.search.PatentSearch
Given that the Google Web Search API is a work in progress, the list of supported services will evolve over time.
google.search.SearcherOptions

When adding individual searchers to the search control, an optional second parameter, the google.search.SearcherOptions object, controls each service's default expansion mode, which affects how search results are displayed in that service's location on the web page. The expansion mode may be one of the following:

google.search.SearchControl.EXPAND_MODE_OPEN
Results are displayed as fully as possible within the object.
google.search.SearchControl.EXPAND_MODE_CLOSED
Results are hidden from view, unless opened through use of a UI element (e.g. an arrow).
google.search.SearchControl.EXPAND_MODE_PARTIAL
Results are shown as a subset of the "open" expansion mode.
// create a searcher options object
// set up for open expansion mode
// load a searcher with these options
var options = new google.search.SearcherOptions();
options.setExpandMode(google.search.SearchControl.EXPAND_MODE_OPEN);
searchControl.addSearcher(new google.search.WebSearch(), options);
Controlling Expansion Mode

The following example demonstrates the use of a search control in which each searcher is operating in a different expansion mode. Note that if the searcher is being drawn in tabbed mode, expansion mode is ignored. In that case, the searcher always operates in open mode.

// local search, partial
options = new google.search.SearcherOptions();
options.setExpandMode(google.search.SearchControl.EXPAND_MODE_PARTIAL);
searchControl.addSearcher(new google.search.LocalSearch(), options);

// web search, open
options = new google.search.SearcherOptions();
options.setExpandMode(google.search.SearchControl.EXPAND_MODE_OPEN);
searchControl.addSearcher(new google.search.WebSearch(), options);
Controlling Searcher Results Location

In some applications, it is desirable to project search results for a given service into an arbitrary location on the web page. This mode of operation is supported by using the setRoot() method of the service's corresponding searcher object.

// web search, open, alternate root
var options = new google.search.SearcherOptions();
options.setExpandMode(google.search.SearchControl.EXPAND_MODE_OPEN);
options.setRoot(document.getElementById("somewhere_else"));
searchControl.addSearcher(new google.search.WebSearch(), options);
Keeping a Search Result

The samples so far have focused on embedding search results on your page for display only, without the capability to store those results to another application. While this is a perfectly appropriate use of the Google Web Search API, it does not demonstrate its true potential. The Google Web Search API is designed to allow users to distribute search results to others, primarily through content creation applications like blog posts, message boards, etc.

The google.search.SearchControl object provides this functionality through its setOnKeepCallback() method. Using this method, applications specify an object and method that is called whenever a user indicates the wish to save a search result by clicking the "Copy" link below the result.

This link is only provided if applications have called setOnKeepCallback() method. When a user clicks the link, the registered callback receives a GResult instance representing the search result. This search results object contains a number of searcher specific properties, as well as a uniform html property that contains an HTML element representing the entire search result. The simplest way to handle the callback is to clone the html node and attach it to a node in your application's DOM.

// establish a keep callback
searchControl.setOnKeepCallback(this, MyKeepHandler);

function MyKeepHandler(result) {
  // clone the result html node
  var node = result.html.cloneNode(true);

  // attach it
  var savedResults = document.getElementById("saved_results");
  savedResults.appendChild(node);
}
Setting Site Restrictions

In some situations, you might want to restrict a web search, news search, or blog search to a specific site or blog. When you apply restrictions like this, you would typically also want to set your own custom label on the associated section of search results, and you might want to style this section of results differently.

All of these capabilities are supported by using a combination of methods exposed by the searcher options. The following sample demonstrates the use of .setUserDefinedLabel(), .setUserDefinedClassSuffix(), and .setSiteRestriction(). The sample creates a search control where one instance of google.search.WebSearch is site restricted to only return results from amazon.com, uses "Amazon.com" as the search section label, and applies some amount of custom css styling to this section (bold title, orange keeper button, etc.). A similar section showing site restrictions on a google.search.BlogSearch and on google.search.NewsSearch is also demonstrated.

<style type="text/css">
/* customize checkbox for -siteSearch section and
 * set section title and keep label to bold
 */
.gsc-resultsRoot-siteSearch .gsc-keeper {
  background-image : url('../../css/orange_check.gif');
  font-weight : bold;
}
.gsc-resultsRoot-siteSearch .gsc-title { font-weight : bold; }
...

// site restricted web search with custom label
// and class suffix
var siteSearch = new google.search.WebSearch();
siteSearch.setUserDefinedLabel("Amazon.com");
siteSearch.setUserDefinedClassSuffix("siteSearch");
siteSearch.setSiteRestriction("amazon.com");
searchControl.addSearcher(siteSearch);

// site restricted web search using a custom search engine
siteSearch = new google.search.WebSearch();
siteSearch.setUserDefinedLabel("Product Reviews");
siteSearch.setSiteRestriction("000455696194071821846:reviews");
searchControl.addSearcher(siteSearch);
        
Search Control Callbacks

In some situations, you want to use the search control because it provides all the UI that you need, but you have a need to see and partially process search results as they arrive. Instead of resorting to the google.search.Search layer where you have this capability, but are then responsible for the UI, the search control exposes a pair of callbacks. You can use these to request notification before a search executes and after a search completes. Note, you can not count on a given execute resulting in a completion. The completion may never occur, so don't code yourself into a deadlock. A typical example of this occurs when you might want to plot local search results on a nearby map.

The following code snippet demonstrates the use of this capability.

searchControl.setSearchCompleteCallback(this, App.prototype.OnSearchComplete);
searchControl.setSearchStartingCallback(this, App.prototype.OnSearchStarting);


App.prototype.OnSearchComplete = function(sc, searcher) {

  // if we have local search results, put them on the map
  if ( searcher.results && searcher.results.length > 0) {
    for (var i = 0; i < searcher.results.length; i++) {
      var result = searcher.results["i];

      // if this is a local search result, then proceed...
      if (result.GsearchResultClass == GlocalSearch.RESULT_CLASS ) {
        ...

App.prototype.OnSearchStarting = function(sc, searcher, query) {
  alert("The Query is: " + query);
  ...
        
The following sample is a more complete demonstration of these APIs. It shows how to use these two callbacks to process local search results and place them on an adjacent map.

Custom Search Form

When using google.search.SearchControl, your application can use the integrated "search form", which provides a text input element, a search button, and a clear button, as well as "Powered by Google" branding.

Alternatively, if your application is creating a raw searcher via google.search.Search, you can create a standalone search form using google.search.SearchForm(). This object provides the look and feel of the Search Control UI, but is packaged as a standalone object allowing you greater control of both behavior and placement.

The following code snippet demonstrates how to use google.search.SearchForm.

// create a search form without a clear button
// bind form submission to my custom code
var container = document.getElementById("searchFormContainer");
this.searchForm = new google.search.SearchForm(false, container);
this.searchForm.setOnSubmitCallback(this, App.prototype.newSearch);

// called on form submit
App.prototype.newSearch = function(form) {
  if (form.input.value) {
    this.searchControl.execute(form.input.value);
  }
  return false;
}
        
Advanced Branding

When using the google.search.SearchControl or the google.search.SearchForm, your users are naturally exposed to "powered by Google" branding. They are able to associate the search services exposed by your site with Google. When your application does not use either of these forms, it is important to still communicate the Google brand to your users. The google.search.Search.getBranding() method is designed to help you with this. This method accepts an HTML DOM element and attaches the "powered by Google" branding into that element. Alternatively, a "powered by Google" HTML DOM element can be returned to you so that you can attach it directly.

The following code snippet demonstrates the use of this capability.

// attach "powered by Google" branding
google.search.Search.getBranding(document.getElementById("branding"));
...
<div id="branding">Loading...</div>
        
API Overview

The Google Web Search API is made up of several classes of objects:

google.search.SearchControl - This class provides the user interface and coordination over a number of searcher objects, where each searcher object is designed to perform searches and return a specific class of results (Web Search, Local Search, etc.).
google.search.Search - This base class is the class from which all "searchers" inherit. It defines the interface that all searcher services must implement.
GResult - This base class encapsulates the search results produced by the searcher objects.
google.search.SearcherOptions - This class configures the behavior of searcher objects when added to a search control.
This is the expected pattern of use for these classes:

// create a searcher object
var sc = new google.search.SearchControl();

// add one or more searchers, specifying options as needed
var options = new google.search.SearcherOptions();
options.setExpandMode(google.search.SearchControl.EXPAND_MODE_OPEN);
sc.addSearcher(new google.search.WebSearch(), options);
...

// activate the search control by calling it's .draw() method
sc.draw(document.getElementById("myDiv"));
Once you have followed these basic steps, the search control is active. Additional searchers cannot be added and searcher options cannot be modified once a search control is drawn. If you need to change your search control's behavior, you must construct and activate a new search control.

For more information, see the Web Search API class reference.

Styling Search Results

Each search result includes a default .html property that is built with CSS styling in mind. As a result, each piece of semantic information is enclosed in HTML markup with an appropriate set of class markers. This allows you to use this HTML in conjunction with your own custom CSS rules that style the HTML to meet your needs.

As you will see in the sections that follow, each search result is enclosed in a div element marked with a generic search result class of gs-result, as well as a result type specific class e.g., gs-webResult, gs-localResult, etc. This structure allows you to easily define generic CSS rules that are applied to all results, as well as type specific rules.

In addition to this structure, when a result is managed by the google.search.SearchControl, each result is enclosed in a div element marked with a generic search control result class of gsc-result, as well as a result type specific class e.g., gsc-webResult, gsc-localResult, etc. Each section of results is further wrapped in a div element marked with a generic search control results class of gsc-results, as well as a result type specific class e.g., gsc-webResult, gsc-localResult, etc.

The net result of this structure is the following skeleton:

<!-- A collection of web search results in the search control -->
<div class="gsc-results gsc-webResult">

  <!-- A single web result in the search control -->
  <div class="gsc-result gsc-webResult">

    <!-- A single web result, full structure defined below -->
    <div class="gs-result gs-webResult"></div>
  </div>
  ...
</div>

<!-- Similar pattern for local, blog, etc. -->
<div class="gsc-results gsc-localResult"></div>
<div class="gsc-results gsc-blogResult"></div>
  
For detailed information on each search result's CSS structure, visit the following section.

Flash and other Non-Javascript Environments

For Flash developers, and those developers that have a need to access the Web Search API from other Non-Javascript environments, the API exposes a simple RESTful interface. In all cases, the method supported is GET and the response format is a JSON encoded result set with embedded status codes. Applications that use this interface must abide by all existing terms of service. An area to pay special attention to relates to correctly identifying yourself in your requests. Applications MUST always include a valid and accurate http referer header in their requests.

Developers are also encouraged to make use of the userip parameter to supply the IP address of the end-user on whose behalf you are making the API request. Doing so will help distinguish this legitimate server-side traffic from traffic which doesn't come from an end-user.

The easiest way to start learning about this interface is to try it out... Using the command line tool curl or wget, execute the following command:

curl -e http://www.my-ajax-site.com \
'https://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=Paris%20Hilton'
This command performs a Web search (/ajax/services/search/web), for Paris Hilton (q=Paris%20Hilton). The response has a Content-Type of text/javascript; charset=utf-8. You can see from the response below that the responseData is identical to the results and cursor properties described in the Base Search Object documentation.

{"responseData": {
 "results": [
  {
   "GsearchResultClass": "GwebSearch",
   "unescapedUrl": "http://en.wikipedia.org/wiki/Paris_Hilton",
   "url": "http://en.wikipedia.org/wiki/Paris_Hilton",
   "visibleUrl": "en.wikipedia.org",
   "cacheUrl": "http://www.google.com/search?q\u003dcache:TwrPfhd22hYJ:en.wikipedia.org",
   "title": "\u003cb\u003eParis Hilton\u003c/b\u003e - Wikipedia, the free encyclopedia",
   "titleNoFormatting": "Paris Hilton - Wikipedia, the free encyclopedia",
   "content": "\[1\] In 2006, she released her debut album..."
  },
  {
   "GsearchResultClass": "GwebSearch",
   "unescapedUrl": "http://www.imdb.com/name/nm0385296/",
   "url": "http://www.imdb.com/name/nm0385296/",
   "visibleUrl": "www.imdb.com",
   "cacheUrl": "http://www.google.com/search?q\u003dcache:1i34KkqnsooJ:www.imdb.com",
   "title": "\u003cb\u003eParis Hilton\u003c/b\u003e",
   "titleNoFormatting": "Paris Hilton",
   "content": "Self: Zoolander. Socialite \u003cb\u003eParis Hilton\u003c/b\u003e..."
  },
  ...
 ],
 "cursor": {
  "pages": [
   { "start": "0", "label": 1 },
   { "start": "4", "label": 2 },
   { "start": "8", "label": 3 },
   { "start": "12","label": 4 }
  ],
  "estimatedResultCount": "59600000",
  "currentPageIndex": 0,
  "moreResultsUrl": "http://www.google.com/search?oe\u003dutf8\u0026ie\u003dutf8..."
 }
}
, "responseDetails": null, "responseStatus": 200}
In addition to this response format, the protocol also supports a classic JSON-P style callback which is triggered by specifying a callback argument. When this argument is present, the json object is delivered as an argument to the specified callback.

curl -e http://www.my-ajax-site.com \
 'https://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=Paris%20Hilton&callback=processResults'
This command performs a Web search that is identical to the previous search, BUT has been altered to pass callback. With this argument in place, instead of a JSON object being returned, a Javascript call is returned in the response and the JSON object is passed via the results parameter.

processResults({"responseData": {
 "results": [
  {
   "GsearchResultClass": "GwebSearch",
   "unescapedUrl": "http://en.wikipedia.org/wiki/Paris_Hilton",
   "url": "http://en.wikipedia.org/wiki/Paris_Hilton",
   "visibleUrl": "en.wikipedia.org",
   "cacheUrl": "http://www.google.com/search?q\u003dcache:TwrPfhd22hYJ:en.wikipedia.org",
   "title": "\u003cb\u003eParis Hilton\u003c/b\u003e - Wikipedia, the free encyclopedia",
   "titleNoFormatting": "Paris Hilton - Wikipedia, the free encyclopedia",
   "content": "\[1\] In 2006, she released her debut album..."
  },
  {
   "GsearchResultClass": "GwebSearch",
   "unescapedUrl": "http://www.imdb.com/name/nm0385296/",
   "url": "http://www.imdb.com/name/nm0385296/",
   "visibleUrl": "www.imdb.com",
   "cacheUrl": "http://www.google.com/search?q\u003dcache:1i34KkqnsooJ:www.imdb.com",
   "title": "\u003cb\u003eParis Hilton\u003c/b\u003e",
   "titleNoFormatting": "Paris Hilton",
   "content": "Self: Zoolander. Socialite \u003cb\u003eParis Hilton\u003c/b\u003e..."
  },
  ...
 ],
 "cursor": {
  "pages": [
   { "start": "0", "label": 1 },
   { "start": "4", "label": 2 },
   { "start": "8", "label": 3 },
   { "start": "12","label": 4 }
  ],
  "estimatedResultCount": "59600000",
  "currentPageIndex": 0,
  "moreResultsUrl": "http://www.google.com/search?oe\u003dutf8\u0026ie\u003dutf8..."
 }
}
, "responseDetails": null, "responseStatus": 200})
And finally, the protocol supports a callback and context argument. When these url arguments are specified, the response is encoded as a direct Javascript call with a signature of: callback(context, results, status, details, unused). Note the slight difference in the following command and response.

curl -e http://www.my-ajax-site.com \
 'https://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=Paris%20Hilton&callback=foo&context=bar'
This command performs a Web search that is identical to the previous search, BUT has been altered to pass both callback and context. With these arguments in place, instead of a JSON object being returned, a Javascript call is returned in the response and the JSON object is passed via the results parameter.

foo('bar',{
 "results": [
  {
   "GsearchResultClass": "GwebSearch",
   "unescapedUrl": "http://en.wikipedia.org/wiki/Paris_Hilton",
   "url": "http://en.wikipedia.org/wiki/Paris_Hilton",
   "visibleUrl": "en.wikipedia.org",
   "cacheUrl": "http://www.google.com/search?q\u003dcache:TwrPfhd22hYJ:en.wikipedia.org",
   "title": "\u003cb\u003eParis Hilton\u003c/b\u003e - Wikipedia, the free encyclopedia",
   "titleNoFormatting": "Paris Hilton - Wikipedia, the free encyclopedia",
   "content": "In 2006, she released her debut album \u003cb\u003eParis\u003c/b\u003e..."
  },
  {
   "GsearchResultClass": "GwebSearch",
   "unescapedUrl": "http://www.imdb.com/name/nm0385296/",
   "url": "http://www.imdb.com/name/nm0385296/",
   "visibleUrl": "www.imdb.com",
   "cacheUrl": "http://www.google.com/search?q\u003dcache:1i34KkqnsooJ:www.imdb.com",
   "title": "\u003cb\u003eParis Hilton\u003c/b\u003e",
   "titleNoFormatting": "Paris Hilton",
   "content": "Self: Zoolander. Socialite \u003cb\u003eParis Hilton\u003c/b\u003e was..."
  },
  ...
 ],
 "cursor": {
  "pages": [
   { "start": "0", "label": 1 },
   { "start": "4", "label": 2 },
   { "start": "8", "label": 3 },
   { "start": "12","label": 4 }
  ],
  "estimatedResultCount": "59600000",
  "currentPageIndex": 0,
  "moreResultsUrl": "http://www.google.com/search?oe\u003dutf8..."
 }
}
, 200, null)
Code Snippets


The following section's show code snippets that demonstrate API access from Flash, Java, and php. If you have any issues processing the JSON response, make sure you visit the JSON.org site and pay close attention to the second half of the page where various JSON libraries are referenced. See this table mapping methods to base URLS for details on how the various Google API services described in the previous sections are made available through the REST API.

Flash Access

The following code snippet demonstrates how to make a request to the Web Search API from Flash. Note use JSON from the ActionScript 3.0 (AS3) Core Library.

var service:HTTPService = new HTTPService();
service.url = 'https://ajax.googleapis.com/ajax/services/search/web';
service.request.v = '1.0';
service.request.q = 'Paris Hilton';
service.resultFormat = 'text';
service.addEventListener(ResultEvent.RESULT, onServerResponse);
service.send();

private function onServerResponse(event:ResultEvent):void {
  try {
    var json:Object = JSON.decode(event.result as String);
    // now have some fun with the results...
  } catch(ignored:Error) {
  }
}
Java Access

The following code snippet demonstrates how to make a request to the Web Search API from Java. Note use of the json library from http://www.json.org/java/

// The request also includes the userip parameter which provides the end
// user's IP address. Doing so will help distinguish this legitimate
// server-side traffic from traffic which doesn't come from an end-user.
URL url = new URL(
    "https://ajax.googleapis.com/ajax/services/search/web?v=1.0&"
    + "q=Paris%20Hilton&userip=USERS-IP-ADDRESS");
URLConnection connection = url.openConnection();
connection.addRequestProperty("Referer", /* Enter the URL of your site here */);

String line;
StringBuilder builder = new StringBuilder();
BufferedReader reader = new BufferedReader(new InputStreamReader(connection.getInputStream()));
while((line = reader.readLine()) != null) {
 builder.append(line);
}

JSONObject json = new JSONObject(builder.toString());
// now have some fun with the results...
Php Access

The following code snippet demonstrates how to make a request to the Web Search API from php. Note, this sample assumes PHP 5.2. For older installations of PHP, refer this comment.

// The request also includes the userip parameter which provides the end
// user's IP address. Doing so will help distinguish this legitimate
// server-side traffic from traffic which doesn't come from an end-user.
$url = "https://ajax.googleapis.com/ajax/services/search/web?v=1.0&"
    . "q=Paris%20Hilton&userip=USERS-IP-ADDRESS";

// sendRequest
// note how referer is set manually
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_REFERER, /* Enter the URL of your site here */);
$body = curl_exec($ch);
curl_close($ch);

// now, process the JSON string
$json = json_decode($body);
// now have some fun with the results...
Python Access

The following code snippet demonstrates how to make a request to the Web Search API from Python. Note, this sample assumes Python 2.4 or higher and you may need to download and install simplejson.

import urllib2
import simplejson

# The request also includes the userip parameter which provides the end
# user's IP address. Doing so will help distinguish this legitimate
# server-side traffic from traffic which doesn't come from an end-user.
url = ('https://ajax.googleapis.com/ajax/services/search/web'
       '?v=1.0&q=Paris%20Hilton&userip=USERS-IP-ADDRESS')

request = urllib2.Request(
    url, None, {'Referer': /* Enter the URL of your site here */})
response = urllib2.urlopen(request)

# Process the JSON string.
results = simplejson.load(response)
# now have some fun with the results...
Perl Access

The following code snippet demonstrates how to make a request to the Web Search API from Perl. Note, this sample relies on the LWP::UserAgent and JSON modules which you can obtain from CPAN. You may also want to use the URI::Escape module.

#!/usr/bin/perl
# The request also includes the userip parameter which provides the end
# user's IP address. Doing so will help distinguish this legitimate
# server-side traffic from traffic which doesn't come from an end-user.
my $url = "https://ajax.googleapis.com/ajax/services/search/web?v=1.0&"
    . "q=Paris%20Hilton&userip=USERS-IP-ADDRESS";

# Load our modules
# Please note that you MUST have LWP::UserAgent and JSON installed to use this
# You can get both from CPAN.
use LWP::UserAgent;
use JSON;

# Initialize the UserAgent object and send the request.
# Notice that referer is set manually to a URL string.
my $ua = LWP::UserAgent->new();
$ua->default_header("HTTP_REFERER" => /* Enter the URL of your site here */);
my $body = $ua->get($url);

# process the json string
my $json = from_json($body->decoded_content);

# have some fun with the results
my $i = 0;
foreach my $result (@{$json->{responseData}->{results}}){
 $i++;
 print $i.". " . $result->{titleNoFormatting} . "(" . $result->{url} . ")\n";
 # etc....
}
if(!$i){
 print "Sorry, but there were no results.\n";
}
Further reading

For complete documentation on this interface, please visit the class reference manual.

Troubleshooting

If you encounter problems with your code:

Look for typos. Remember that JavaScript is a case-sensitive language.
Use a JavaScript debugger. In Firefox, you can use the JavaScript console or the Firebug. In IE, you can use the Microsoft Script Debugger.
Search the Web Search API discussion group. If you can't find a post that answers your question, post your question to the group along with a link to a web page that demonstrates the problem.