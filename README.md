# Building Gutenberg Blocks

This repo contains various code examples to be used in my talk about building Gutenberg blocks.

## Stage 1 - Setup

### Local WordPress Install

In order to get started, we should have a fresh, local install of WordPress. If you have never used a local environment, I recommend [Local By Flywheel](https://localbyflywheel.com/). It is free to use and configures everything for you.

### Node.js Installed

You will need [Node.js](https://nodejs.org/en/download/) to run [create-guten-block](https://github.com/ahmadawais/create-guten-block), the package that will set up our block building environment for us. If you do not have [Node.js](https://nodejs.org/en/download/) installed, you can download it [here](https://nodejs.org/en/download/).

### Create a Gutenberg block

With a fresh install of WordPress and Node.js running on our machine the only thing left to do is create our Gutenberg block plugin! 

1. Navigate to your plugins folder in terminal. (You can open Terminal, type `cd `, drag your plugins folder from a Finder window into your Terminal window, and hit enter to do this quickly)

2. Run `npx create-guten-block my-block` where `my-block` is the name of your block.

3. Log into your local WordPress install, activate your newly created plugin on the Plugins screen, and add your block to a page!

## Stage 2 - RichText and Attributes

Our block is working, but its static. It doesn't do anything yet, but with a few modifications, we can give it an editable heading.

We will be using a component called `<RichText>`. There are a lot of built in components we can use in our blocks. You can check them all out [here](https://wp-storybook.netlify.com/). Or you can write your own. Theyre just React components. 

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