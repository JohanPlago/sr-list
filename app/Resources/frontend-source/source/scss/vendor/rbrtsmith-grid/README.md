# rbrtsmith-grid
fluid, nestable, equal heights, vertical alignment, horizontal reversal, minimal bloat, fractional based grid.


##Features
* Fluid
* Infinitely nestable
* Optional equal height grid items based on flexbox (IE10+) IE9 falls back to 
the standard grid.
* Optional vertical alignment of grid items (when heights differ).
* Optional vertical gutters&mdash;which match the width of horizontal gutters.
* Large, standard, small or zero gutters&mdash;all of which are customizable.
* Ability to reverse the horizontal order of all grid-items via a single classname.
* No clearfixing required, rows of items with uneven heights tile gracefully.
* Based on fractions rather than columns yielding increased flexibility over
  some more traditional approaches that use a fixed number of columns.
* Intuitive class names based on fractions and a BEM methodology hybrid known as [BEMIT](http://csswizardry.com/2015/08/bemit-taking-the-bem-naming-convention-a-step-further/#responsive-suffixes)
`u-1/4@sm-up` = width one quarter at screens larger than the `screen-sm` breakpoint.
* Does not require a wrapping element like most other grid systems.
* Extremely lightweight you can include only the
  features that you require via the `Feature-toggle` list and the Sass compiler will ommit classes set to `false`.
* Width, push and pull classes are not tied directly to the grid, and can be 
  reused anywhere in your project.
* Ability to use any number of user-defined breakpoints with user defined
  namespaces to match.

##Demo
[A quick overview of the features](http://codepen.io/rbrtsmith/full/VvdGMp/)

##Setup

###Installation
Either pull down this repository via Git or you can use Bower:  
`bower install rbrtsmith-grid`

### A word on CSS minification
Some CSS minifiers change the source order of your CSS and merge media querys.This will cause rbrtsmith-grid to break as it's width, push and pull classes are dependant upon source order. It's also generally a bad idea to be reordering our CSS as it is source order dependant.  
As such we should ideally be writing our CSS in [specificity order](http://csswizardry.com/2014/10/the-specificity-graph/).  

The minifier I use is [clean css](https://github.com/jakubpawlowicz/clean-css) and I run ít with the flag `--skip-advanced` to stop this reordering and merging.  
If you are using Gulp and the plugin [gulp-minify-css](https://www.npmjs.com/package/gulp-minify-css) which is essentially a wrapper for clean-css then you will need to pipe the following: `.pipe(minifyCSS({'advanced': false}))`.

Having more media querys in your CSS will make almost zero difference after everything is Gzipped, it deals with repetition extremely well.

###Vars
Either roll with the defaults or simply adjust the values wherever necessary&hellip;
* `$grid-gutter-width` set the width of the guttering.
* `$gutter-lg-width` width of large gutters.
* `$gutter-sm-width` width of small gutters.
* `$grid-font-size` Due to using inline-blocks on the `.grid__items` we have to
 set the font-size on the `.grid` block to zero to remove unwanted whitespace,
 which would otherwise cause the grid to fail.  This font-size value will be
 set on each individual item and should equal the base font size of your project.
* `$grid-breakpoints` is a nested Sass list that contains all the grid's 
breakpoints that will be used on width, push and pull classes.  
You can remove unused breakpoints, add in your own, customize the breakpoint's
namespace.

###Feature toggle
A list of feature switches, that are all set to true by default.  Set any that
you are not using to false to keep out as much bloat as possible from the
resulting CSS.
* `$use-grid` skeleton of the grid system.
* `$use-grid--equal-height` equal height grid items.
* `$use-grid--center` vertically center grid items.
* `$use-grid--bottom` vertically align grid-items to the bottom.
* `$use-grid--gutter-lg` larger gutter.
* `$use-grid--gutter-sm` smaller gutter.
* `$use-grid--no-gutter` remove gutter.
* `$use-grid--matrix` vertical gutter matching horizontal gutter.
* `$use-grid--reverse` reverse horizontal ordering of grid items.

You can also toggle specific width, push and pull classes.  Responsive classes
are controlled by the `$grid-breakpoints` list in the `VARS` section and are
automatically added to activated width, push and pull classes.

##Useage
rbrtsmith grids is easy to use and customize.
Using [BEMIT](http://csswizardry.com/2015/08/bemit-taking-the-bem-naming-convention-a-step-further/#responsive-suffixes) 
based class names paired with fractions the markup becomes extremely descriptive 
and concise.  
Those not familiar with BEMIT here's a short introduction&hellip;
###BEMIT
Based on [BEM](http://csswizardry.com/2013/01/mindbemding-getting-your-head-round-bem-syntax/) 
which stands for **B**lock **E**lement **M**odifier.  BEMIT extends
on BEM to add in additional prefixing and responsive suffixes to better describe
the intentions of the components.

####BEM####
* `.grid` is a **B**lock
* `.grid--equal-height` is a **M**odifier as signified by `--`
* `.grid__item` is an **E**lement as signified by `__` which is a descendant
of a block.

####BEMIT - prefixes####
I use the [ITCSS](https://twitter.com/itcss_io) system in my projects so I have 
added **Object** and **Utility** prefixes to this grid that better describe 
where they live within ITCSS.  
* `o-grid` is an object class as signified by `o-`
* `o-grid__item` is also an object class.
* `u-1/2` &nbsp; `u-push-2/3` are both utility classes as signified by `u-`

####BEMIT - responsive suffixes####
* `u-1/2@sm-up` has the responsive suffix that suggests that this class will
be applied to screens larger than the `sm-up` breakpoint.

Further examples of responsive suffixes:
* `u-push-2/3@lg-up` breakpoints larger than `lg-up` as signified by `@lg-up`
* `u-pull-5/6@xs-up` breakpoints larger than `xs-up` as signified by `@xs-up`

####Fractions####
Although not a part of BEMIT, fractions can better describe widths and offsets
than set column numbers.  The values simply get converted to a percentage of the
parent container `.grid` via a Sass mixin so `1/2 = 50%` &nbsp; `2/3 = 66.66%`.
* `u-1/2` 50% width.
* `u-2/3@sm-up` 66.66% width for viewports greater than `sm-up` breakpoint.
* `u-pull-1/10@lg-up` pull to the left by 10% at viewports greater than `lg-up`
breakpoint.


##Examples in markup##

**Basic bare bones grid component.**
```html
<div class="o-grid">
    <div class="o-grid__item">
        [CONTENT]
    </div>
</div>
```

###Width classes###
**Grid component with two columns at viewports greater than `sm-up`.**  
[Demo of all width classes](http://codepen.io/rbrtsmith/full/VvdExG/)
```html
<div class="o-grid">
    <div class="o-grid__item u-1/3@sm-up">
        [CONTENT] <!-- I'm 33.33% wide -->
    </div>
    <div class="o-grid__item u-2/3@sm-up">
        [CONTENT] <!-- I'm 66.66% wide -->
    </div>
</div>
```

**You can easily compose multiple breakpoints and widths.**
```html
<div class="o-grid">
    <div class="o-grid__item u-1/2@sm-up u-1/4@lg-up">
        [CONTENT] <!-- I'm 50% wide @sm-up and 25% wide @lg-up -->
    </div>
    <div class="o-grid__item u-1/2@sm-up u-1/4@lg-up">
        [CONTENT] <!-- I'm 50% wide @sm-up and 25% wide @lg-up -->
    </div>
    <div class="o-grid__item u-1/2@sm-up u-1/4@lg-up">
        [CONTENT] <!-- I'm 50% wide @sm-up and 25% wide @lg-up -->
    </div>
    <div class="o-grid__item u-1/2@sm-up u-1/4@lg-up">
        [CONTENT] <!-- I'm 50% wide @sm-up and 25% wide @lg-up -->
    </div>
</div>
```

###Push &amp; Pull classes###
Use to shift individual items horizontally using `position: relative` combined 
with `left` or `right` values.
Like the width classes you can add responsive suffices and compose multiple 
combinations.

**Push**
```html
<div class="o-grid">
    <div class="o-grid__item u-1/3 u-push-1/4@sm-up">
        [CONTENT] <!-- I'm 33.33% wide and pushed to the right by 25% @sm-up -->
    </div>
</div>
```

**Pull**
```html
<div class="o-grid">
    <div class="o-grid__item u-1/3 u-pull-1/4@lg-up">
        [CONTENT] <!-- I'm 33.33% wide and pulled to the left by 25% @lg-up -->
    </div>
</div>
```

###Grid modifiers###
This is where the true power of this grid system comes in, where we can set
equal height items, vertically align them etc&hellip;

**Equal heights**
```html
<div class="o-grid o-grid--equal-height">
    <div class="o-grid__item u-1/2">
        [CONTENT] <!-- No matter what content we contain we'll be equal in height -->
    </div>
    <div class="o-grid__item u-1/2">
        [CONTENT] <!-- No matter what content we contain we'll be equal in height -->
    </div>
</div>
```

**Equal heights centered content**  
*Of course you would replace the inline styles with your own BEM block&hellip;*
```html
<div class="o-grid o-grid--equal-height o-grid--equal-height--centered-content">
    <div class="o-grid__item u-1/2">
        <div style="background: cornflour;">
            [CONTENT] <!-- No matter what content we contain we'll be equal in height and the text centered -->
        </div>
    </div>
    <div class="o-grid__item u-1/2">
        <div style="background: cornflour;">
            [CONTENT] <!-- No matter what content we contain we'll be equal in height and the text centered -->
        </div>
    </div>
</div>
```

**Vertically aligned to the center**
```html
<div class="o-grid o-grid--center">
    <div class="o-grid__item u-1/2">
        [CONTENT] <!-- we'll be vertically centered no matter what our heights are -->
    </div>
    <div class="o-grid__item u-1/2">
        [CONTENT] <!-- we'll be vertically centered no matter what our heights are -->
    </div>
</div>
```

**Vertically aligned to the bottom**
```html
<div class="o-grid o-grid--bottom">
    <div class="o-grid__item u-1/2">
        [CONTENT] <!-- we'll vertically aligned to the bottom -->
    </div>
    <div class="o-grid__item u-1/2">
        [CONTENT] <!-- we'll vertically aligned to the bottom -->
    </div>
</div>
```

**Large gutter**
```html
<div class="o-grid o-grid--gutter-lg">
    <div class="o-grid__item u-1/2">
        [CONTENT] <!-- We have larger guttering -->
    </div>
    <div class="o-grid__item u-1/2">
        [CONTENT] <!-- We have larger guttering -->
    </div>
</div>
```

**Small gutter**
```html
<div class="o-grid o-grid--gutter-sm">
    <div class="o-grid__item u-1/2">
        [CONTENT] <!-- We have smaller guttering -->
    </div>
    <div class="o-grid__item u-1/2">
        [CONTENT] <!-- We have smaller guttering -->
    </div>
</div>
```

**No gutter**
```html
<div class="o-grid o-grid--gutter-no-gutter">
    <div class="o-grid__item u-1/2">
        [CONTENT] <!-- We have No gutter -->
    </div>
    <div class="o-grid__item u-1/2">
        [CONTENT] <!-- We have No gutter -->
    </div>
</div>
```

**Matrix**
```html
<div class="o-grid o-grid--matrix">
    <div class="o-grid__item u-1/2">
        [CONTENT] <!-- We have vertical gutters as well as horizontal -->
    </div>
    <div class="o-grid__item u-1/2">
        [CONTENT] <!-- We have vertical gutters as well as horizontal -->
    </div>
    <div class="o-grid__item u-1/2">
        [CONTENT] <!-- We have vertical gutters as well as horizontal -->
    </div>
    <div class="o-grid__item u-1/2">
        [CONTENT] <!-- We have vertical gutters as well as horizontal -->
    </div>
</div>
```

**Reverse**
```html
<div class="o-grid o-grid--reverse">
    <div class="o-grid__item u-1/2">
        [CONTENT] <!-- I appear to the right -->
    </div>
    <div class="o-grid__item u-1/2">
        [CONTENT] <!-- I appear to the left -->
    </div>
</div>
```

##Composing grid modifiers##
You can compose multiple modifiers to give even more control.

**Matrix with small gutters and equal height items**
```html
<div class="o-grid o-grid--matrix o-grid--gutter-sm o-grid--equal-height">
    <div class="o-grid__item u-1/2">
        [CONTENT] <!-- So much control! -->
    </div>
    <div class="o-grid__item u-1/2">
        [CONTENT] <!-- So much control! -->
    </div>
    <div class="o-grid__item u-1/2">
        [CONTENT] <!-- So much control! -->
    </div>
    <div class="o-grid__item u-1/2">
        [CONTENT] <!-- So much control! -->
    </div>
</div>
```

##Nesting##
You can infinitely nest grids inside of one another like this example
```html
<div class="o-grid">
    <div class="o-grid__item u-1/2">
        <div class="o-grid">
            <div class="o-grid__item u-1/2">
                1.1
            </div>
            <div class="o-grid__item u-1/2">
                1.2
            </div>
        </div>
    </div>
    <div class="o-grid__item u-1/2">
        <div class="o-grid__item u-1/2">
                2.1
            </div>
            <div class="o-grid__item u-1/2">
                2.2
            </div>
        </div>
    </div>
</div>
```

##Misc##
It is also possible to horizontally align the grid items using `text-align`
which you can define as utility classes in your Sass:
```css
.text-center {
    text-align: center;
}

.text-right {
    text-align: right;
}
```
and then in your markup:
```html
<div class="o-grid text-center">
    <div class="o-grid__item u-1/4">
        [CONTENT] <!-- We're horizontally centered -->
    </div>
    <div class="o-grid__item u-1/4">
        [CONTENT] <!-- We're horizontally centered -->
    </div>
</div>
```

**Or**

```html
<div class="o-grid text-right">
    <div class="o-grid__item u-1/4">
        [CONTENT] <!-- We're to the right -->
    </div>
    <div class="o-grid__item u-1/4">
        [CONTENT] <!-- We're to the right -->
    </div>
</div>
```
This can be useful when dealing with content from a CMS when you have an unknown
quantity of boxes and the client wants them to always be centered.

##Acknowledgments
This grid system is Heavily influenced by the great work of
[@csswizardry](https://twitter.com/csswizardry]) and borrows many ideas from
his writings and grid system [csswizardry-grids](https://github.com/csswizardry/csswizardry-grids).

If you haven't already had the privilege of reading Harry's blog then I really 
urge you to dive right in.  It's quite literally a goldmine of useful 
information and techniques.
[http://csswizardry.com](http://csswizardry.com)




