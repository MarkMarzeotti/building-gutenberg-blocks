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