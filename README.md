# Building Gutenberg Blocks

This repo contains various code examples to be used in my talk about building Gutenberg blocks.

## Stage 1 - Setup

### Local WordPress Install

In order to get started, we should have a fresh, local install of WordPress. If you have never used a local environment, I recommend [Local By Flywheel](https://localbyflywheel.com/). It is free to use and configures everything for you.

### Node.js Installed

You will need [Node.js](https://nodejs.org/en/download/) to run [create-guten-block](https://github.com/ahmadawais/create-guten-block), the package that will set up our block building environment for us. If you do not have [Node.js](https://nodejs.org/en/download/) installed, you can download it [here](https://nodejs.org/en/download/).

### Create a Gutenberg block

With a fresh install of WordPress and Node.js running on our machine the only thing left to do is create our Gutenberg block plugin! 

1. Navigate to your plugins folder in terminal. (You can open Terminal, type `cd `, drag your plugins folder from a Finder window into your Terminal window, and hit enter to do this quickly).

2. Run `npx create-guten-block my-block` where `my-block` is the name of your block.

3. Log into your local WordPress install, activate your newly created plugin on the Plugins screen, and add your block to a page!

## Stage 2 - RichText and Attributes

Our block is working, but its static. It doesn't do anything yet, but with a few modifications, we can give it an editable heading.

We will be using a component called `<RichText>`. There are a lot of built in components we can use in our blocks. You can check them all out [here](https://wp-storybook.netlify.com/). Or you can write your own. They're just React components. 

1. In order to see any changes to our block we need to begin compiling our changes. In terminal run `npm start` to use Webpack to compile changes to our block.

2. In your favorite code editor, open the file controlling our block. It is located at `my-block/src/block/block.js` where `my-block` is the name of your block.

3. We are going to give our block an editable heading. In order to do that, we will need to add a few lines to our block. First we'll let the block know we will be saving some data, and a little info on where that data will be. Add the following lines between `category` and `keywords`.
    ```javascript
    attributes: {
        heading: {
            source: 'children',
            selector: 'h2',
            type: 'array',
        },
    },
    ```
    This tells our block that we will have 1 attribute, and that it will be found inside the H2 tag.

4. We need to import the `<RichText>` component to use it in our block. Add the following after `const { registerBlockType } = wp.blocks;` in block.js.
    ```javascript
    const { RichText } = wp.editor;
    ```
    We can now use the `<RichText>` component in our edit and save functions.

5. Add the `<RichText>` component to the edit function. I did it right inside the opening div.
    ```javascript
    <RichText
        tagName="h2"
        value={ props.attributes.heading }
        onChange={ ( heading ) => props.setAttributes( { heading } ) }
        placeholder="Write your heading"
        keepPlaceholderOnFocus={ true }
    />
    ```
    You'll notice all the calls to `props.attributes.heading`. That's the attribute we defined in step 3.

6. Finally add the `<RichText>` component's data to the save function. 
    ```javascript
    <RichText.Content 
        tagName="h2" 
        value={ props.attributes.heading } 
    />
    ```
    Ideally you'll want it in the same place you put it in the edit function. The idea here is the end user getting a good idea of what the block will look like on the front end.

7. Save your work. Webpack should still be running in Terminal and has been watching your files for changes. Take a look at your block in the WordPress Admin. It should now have your placeholder displayed in an editable area. Enter a heading, update your page, and checkout your post on the front end.

## Stage 3 - A Practical Example

We have a block with some basic functionality. Now lets build a block a client might actually ask for. What Gutenberg is really great at is mixing new functionality in with regular content. With the Classic Editor we could add headings, paragraphs, lists, etc, but what if we wanted to add something that isnt as simple as an HTML tag like an accordion/dropdown?

For this example lets make a simple dropdown that has a heading that is immediately visible, but when clicked reveals content that was initially hidden. In the Classic Editor we may have used a shortcode or Advanced Custom Fields to do this sort of thing. A shortcode would allow us to add this in the content, but still leaves a lit to be desired. Using ACF would require either predefined locations this would be allowed, or all of our content to be in a Flexible Content field. Gutenberg will allow us to build a block that will handle all of the functionality.

1. The easiest way to start this might be to start with our first block. But we want to keep that block for now so copy the entire block folder and rename the block. Then add the call to the new block in blocks.js. You will also need to rename the class in your .scss files to reference your new block and remove the existing styles to make way for our dropdown styles.

2. Now we'll have a block with an editable heading, some static content below, and no styling. We can remove the static content for this block from both the edit and save functions. Now we have a div with a `<RichText>` component that renders as an H2. We are essentially half way there!

3. Now we will need a content section. On the front end we'll want that area to hide and show based on the users interaction, but for the editor, it's probably best if that content is always visible for editing purposes. Let's say we want the user to be able to add paragraphs and lists to this content section, but we dont want to limit the content to just one type or one paragraph or list element. That means the `<RichText>` component won't really work here. What we need to do is allow the user to add blocks inside of this block.

    We will use the `<InnerBlocks>` component that Gutenberg provides. First we need to imprt it like we did with the `<RichText>` component. Lets edit the import for the `<RichText>` component and also import the `<InnerBlocks>` component.

    ```javascript
    const { RichText, InnerBlocks } = wp.editor;
    ```
    We can now use the `<InnerBlocks>` component in our edit and save functions.

4. I added a div to contain all the content so that I can easily style it. I added the `<InnerBlocks>` component inside of it in my edit function.
    ```javascript
    <div className="dropdown-content">
        <InnerBlocks />
    </div>
    ```

5. There is no need to save the content of the `<InnerBlocks>` component like we had to with the `<RichText>` component bacause the content are all blocks themselves. All we need to do is call the children of the `<InnerBlocks>` component in the save function. I wrapped it in the same div as I did in the edit function.
    ```javascript
    <div className="dropdown-content">
        <InnerBlocks.Content />
    </div>
    ```

6. Now we have a block that lets us add a heading and add some blocks to a content area below the heading. We can add some basic styling to make it look more like a dropdown and hide the content by default on the front end. For this project I will only focus on hiding the content on the front end. In the `style.scss` file for this block I have set the content to `display: none`. In the `editor.scss` file I have overidden that style and set the content to `display: block` so it is easily editable.

7. The last thing we would want to do is add the JavaScript that would show or hide the content on click. You can do that however you like but in the interest of keeping all functionality contained in the plugin, I recommend enqueueing a JavaScript file that handles the toggle inside the plugin the same way you might in a theme.

And just like that we have a Dropdown Gutenberg block!