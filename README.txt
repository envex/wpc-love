oooo                                         .                
`888                                       .o8                
 888 .oo.    .ooooo.   .oooo.   oooo d8b .o888oo  .oooo.o     
 888P"Y88b  d88' `88b `P  )88b  `888""8P   888   d88(  "8     
 888   888  888ooo888  .oP"888   888       888   `"Y88b.      
 888   888  888    .o d8(  888   888       888 . o.  )88b .o. 
o888o o888o `Y8bod8P' `Y888""8o d888b      "888" 8""888P' Y8P 

by Matt Vickers & WP Coder
http://wpcoder.com

- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

Thanks for downloading WP Coder Love! Take a minute to read through
this file and get to know the plugin. It's super simple and will
only take a minute!



Usage
- - - - - - - -

Now that you've installed the plugin, how do you use it?!

Step 1: Open up single.php (or whatever file you want to show some love on)
Step 2: Add <?php wpcl_love(); ?> on the page.
Step 3: Have a beer.



Styling
- - - - - - - - 

wpcl_love() will add a link to the page with the class .wpcl_love_this

It doesn't wrap any other tags around the link, so you're free to place it wherever.

Once the user has loved the post (and really, why wouldn't they), a class of .loved is applied to the link.

EXAMPLE TIME

a.wpcl_love_this{
	height: 50px;
	width: 50px;
	text-indent: -9999px;
	display: block;
	background: #e1e1e1;
}

a.wpcl_love_this.loved{
	background: red;
}



Known Issues
- - - - - - - -

1. You won't be able to use this in IE6 or lower. You can't stack classes in those browsers and I really don't feel like supporting that browser anyways :P

