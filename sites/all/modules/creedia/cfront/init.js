// Easing equation, borrowed from jQuery easing plugin
2// http://gsgd.co.uk/sandbox/jquery/easing/
3jQuery.easing.easeOutQuart = function (x, t, b, c, d) {
4 return -c * ((t=t/d-1)*t*t*t - 1) + b;
5};
6
7jQuery(function( $ ){
8 /**
9 * Most jQuery.serialScroll's settings, actually belong to jQuery.ScrollTo, check it's demo for an example of each option.
10 * @see http://flesler.demos.com/jquery/scrollTo/
11 * You can use EVERY single setting of jQuery.ScrollTo, in the settings hash you send to jQuery.serialScroll.
12 */
13
14 /**
15 * The plugin binds 6 events to the container to allow external manipulation.
16 * prev, next, goto, start, stop and notify
17 * You use them like this: $(your_container).trigger('next'), $(your_container).trigger('goto', [5]) (0-based index).
18 * If for some odd reason, the element already has any of these events bound, trigger it with the namespace.
19 */
20
21 /**
22 * IMPORTANT: this call to the plugin specifies ALL the settings (plus some of jQuery.ScrollTo)
23 * This is done so you can see them. You DON'T need to specify the commented ones.
24 * A 'target' is specified, that means that #screen is the context for target, prev, next and navigation.
25 */
26 $('#screen').serialScroll({
27 target:'#sections',
28 items:'li', // Selector to the items ( relative to the matched elements, '#sections' in this case )
29 prev:'img.prev',// Selector to the 'prev' button (absolute!, meaning it's relative to the document)
30 next:'img.next',// Selector to the 'next' button (absolute too)
31 axis:'xy',// The default is 'y' scroll on both ways
32 navigation:'#navigation li a',
33 duration:700,// Length of the animation (if you scroll 2 axes and use queue, then each axis take half this time)
34 force:true, // Force a scroll to the element specified by 'start' (some browsers don't reset on refreshes)
35
36 //queue:false,// We scroll on both axes, scroll both at the same time.
37 //event:'click',// On which event to react (click is the default, you probably won't need to specify it)
38 //stop:false,// Each click will stop any previous animations of the target. (false by default)
39 //lock:true, // Ignore events if already animating (true by default)
40 //start: 0, // On which element (index) to begin ( 0 is the default, redundant in this case )
41 //cycle:true,// Cycle endlessly ( constant velocity, true is the default )
42 //step:1, // How many items to scroll each time ( 1 is the default, no need to specify )
43 //jump:false, // If true, items become clickable (or w/e 'event' is, and when activated, the pane scrolls to them)
44 //lazy:false,// (default) if true, the plugin looks for the items on each event(allows AJAX or JS content, or reordering)
45 //interval:1000, // It's the number of milliseconds to automatically go to the next
46 //constant:true, // constant speed
47
48 onBefore:function( e, elem, $pane, $items, pos ){
49 /**
50 * 'this' is the triggered element
51 * e is the event object
52 * elem is the element we'll be scrolling to
53 * $pane is the element being scrolled
54 * $items is the items collection at this moment
55 * pos is the position of elem in the collection
56 * if it returns false, the event will be ignored
57 */
58 //those arguments with a $ are jqueryfied, elem isn't.
59 e.preventDefault();
60 if( this.blur )
61 this.blur();
62 },
63 onAfter:function( elem ){
64 //'this' is the element being scrolled ($pane) not jqueryfied
65 }
66 });
67
68 /**
69 * No need to have only one element in view, you can use it for slideshows or similar.
70 * In this case, clicking the images, scrolls to them.
71 * No target in this case, so the selectors are absolute.
72 */
73
74 $('#slideshow').serialScroll({
75 items:'li',
76 prev:'#screen2 a.prev',
77 next:'#screen2 a.next',
78 offset:-230, //when scrolling to photo, stop 230 before reaching it (from the left)
79 start:1, //as we are centering it, start at the 2nd
80 duration:1200,
81 force:true,
82 stop:true,
83 lock:false,
84 cycle:false, //don't pull back once you reach the end
85 easing:'easeOutQuart', //use this easing equation for a funny effect
86 jump: true //click on the images to scroll to them
87 });
88
89 /**
90 * The call below, is just to show that you are not restricted to prev/next buttons
91 * In this case, the plugin will react to a custom event on the container
92 * You can trigger the event from the outside.
93 */
94
95 var $news = $('#news-ticker');//we'll re use it a lot, so better save it to a var.
96 $news.serialScroll({
97 items:'div',
98 duration:2000,
99 force:true,
100 axis:'y',
101 easing:'linear',
102 lazy:true,// NOTE: it's set to true, meaning you can add/remove/reorder items and the changes are taken into account.
103 interval:1, // yeah! I now added auto-scrolling
104 step:2 // scroll 2 news each time
105 });
106
107 /**
108 * The following you don't need to see, is just for the "Add 2 Items" and "Shuffle"" buttons
109 * These exemplify the use of the option 'lazy'.
110 */
111 $('#add-news').click(function(){
112 var
113 $items = $news.find('div'),
114 num = $items.length + 1;
115
116 $items.slice(-2).clone().find('h4').each(function(i){
117 $(this).text( 'News ' + (num + i) );
118 }).end().appendTo($news);
119 });
120 $('#shuffle-news').click(function(){//don't shuffle the first, don't wanna deal with css
121 var shuffled = $news.find('div').get().slice(1).sort(function(){
122 return Math.round(Math.random())-0.5;//just a random number between -0.5 and 0.5
123 });
124 $(shuffled).appendTo($news);//add them all reordered
125 });
126});