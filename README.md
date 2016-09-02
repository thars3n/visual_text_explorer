The Visual Text Exlporer is a tool that searches for words, phrases, or characters within a provided text. The user provides a source file and list file that includes the terms they would like to search for in the text, and then the VTE will parse the text and output a series of SVGs that highlight the words within the text. For examples, look in the example folder for PDFs that show the rendered output. The VTE utilizes UTF-8 unicode, so it can work with practically any language.


The VTE uses php to parse the source text on the serverside, and then Javascript and D3 are used to render the output. The rest of the page is written in a combination of CSS, HTML, and Javascript.
