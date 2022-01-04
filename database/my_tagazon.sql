-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 04, 2022 at 10:41 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_tagazon`
--

-- --------------------------------------------------------

--
-- Table structure for table `buyers`
--

CREATE TABLE `buyers` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `buyers`
--

INSERT INTO `buyers` (`id`, `email`, `password`, `name`, `surname`) VALUES
(1, 'buyer0@email.com', '$2y$10$S3OZmRNyhC3FzHki25TdTeKumLf0s4QoDOO2Fh7O803pIeJmKwyY6', 'Buyer0', 'Surname0'),
(2, 'buyer1@email.com', '$2y$10$wBdFsn6/CB0RLROfRGJvueS5ihkrrNtT4deWpupoItcF6UKuq0ZBG', 'Buyer1', 'Surname1'),
(3, 'buyer2@email.com', '$2y$10$GUwRrJ4mSXetrnVewugWYexi929vxm6ofNIpuXmEQMcA.aqAuSoS2', 'Buyer2', 'Surname2'),
(4, 'buyer3@email.com', '$2y$10$jWcabYRufCoYK7eogS6dUOd2tO5qdHeZuHjkaRX1ChLR8cpDHK8L2', 'Buyer3', 'Surname3'),
(5, 'buyer4@email.com', '$2y$10$bfuzjFLfCjybL6d0Z7LIdeafoOOY2vpgAxw4jVCHVkRDcwINbCfyO', 'Buyer4', 'Surname4'),
(6, 'buyer5@email.com', '$2y$10$BUMkxDdcaNkh9gZxcGp2DeuywDavXXE6svGQoojMTjBMQuKY6Jo/6', 'Buyer5', 'Surname5'),
(7, 'buyer6@email.com', '$2y$10$3L0BoYN1nTFauA6pphqNIuAad7D894GeXQnT3wf3KX91CA8yUyQhK', 'Buyer6', 'Surname6'),
(8, 'buyer7@email.com', '$2y$10$EJf1ATb7TBM5q4bwOW200eAIPvOOyzJEnYFZy.I0gfNpVrQUil8nC', 'Buyer7', 'Surname7'),
(9, 'buyer8@email.com', '$2y$10$PCIv2w2K.KSG7uVBKEYg5eEnv4fhIpnSpUGvjZ9Eh2MJMZGNO49Pa', 'Buyer8', 'Surname8'),
(10, 'buyer9@email.com', '$2y$10$/5nauPB2GlNKMSel2l16MOF8HC278ZmY1F0QxACwpR.hnYBOi2QGW', 'Buyer9', 'Surname9');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'flow', 'Flow content is a broad category that encompasses most elements that can go inside the <body> element, including heading elements, sectioning elements, phrasing elements, embedding elements, interactive elements, and form-related elements. It also includes text nodes (but not those that only consist of white space characters)'),
(2, 'phrasing', 'Phrasing content is any textual content that is not a child of a flow content, or a flow content that is not a child of a phrasing content. This includes text nodes, comments, elements with no children, and elements that are children of a flow content, but not phrasing content.'),
(3, 'interactive', 'Interactive content is content that requires user input, such as user interface controls, or a <button> element.'),
(4, 'embedded', 'Embedded content is content that is embedded, or could be embedded, in other content. Examples include applets, frames, iframes, and plug-ins.'),
(5, 'sectioning', 'Sectioning content is content that is a heading, or a group of headings that are related and are repeated in the same document more than once.'),
(6, 'heading', 'Heading content is content that is a heading, or a group of headings that are related but are not repeated in the same document.'),
(7, 'metadata', 'Metadata content is information that is not meant for presentation, such as a <meta> element, a <link> element, a <script> element, or a <style> element.');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `title` text NOT NULL,
  `message` text NOT NULL,
  `received` tinyint(1) NOT NULL DEFAULT 0,
  `seen` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `buyer` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) NOT NULL,
  `amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `order_tags`
--

CREATE TABLE `order_tags` (
  `id` int(11) NOT NULL,
  `tag` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `card-owner` varchar(255) NOT NULL,
  `card-number` int(11) NOT NULL,
  `card-expiry-year` varchar(2) NOT NULL,
  `card-expiry-month` varchar(2) NOT NULL,
  `card-cvc` int(11) NOT NULL,
  `amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rag_soc` varchar(128) NOT NULL,
  `piva` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`id`, `email`, `password`, `rag_soc`, `piva`) VALUES
(1, 'w3c@email.com', '$2y$10$Pi3E5/t5wTLfGp1P99sYZuQ0yylNdtfl.6h9BaSrNUtOryV532eee', 'World Wide Web Consortium', '12345678901'),
(2, 'seller0@email.com', '$2y$10$H6M2CRRufSmfQ6DIoqHYe.eUFo5CZgZe3V/VB.4LYidBEgeFx/ogq', 'Seller0', '1234567890'),
(3, 'seller1@email.com', '$2y$10$/OQxd6nXyU1Sacbho4tp8Obw6jWXnM/wval3eULETjDlaYKUgbMoq', 'Seller1', '1234567891'),
(4, 'seller2@email.com', '$2y$10$sNqwNevJgbQnosG9BJhTFOvvUnhoKw8MMQ/H4Knl///wE9DjyZnum', 'Seller2', '1234567892'),
(5, 'seller3@email.com', '$2y$10$oKheYTEqVBC4zr310AC2ROO5G3EwOQc9DmkoHI9usQlplpJZIvCSW', 'Seller3', '1234567893'),
(6, 'seller4@email.com', '$2y$10$/aojxw2C/2DBq4nmnpaC.uCRzbMUqx.qIm59k6U5HebiVh3rmmGNS', 'Seller4', '1234567894'),
(7, 'seller5@email.com', '$2y$10$0nfsrk6FG/WwqPHsjGM.9uL49u78diQjdJMiqkVjYnJfc2p4.ko9a', 'Seller5', '1234567895'),
(8, 'seller6@email.com', '$2y$10$x2yls3mzbV5E/DtNMMZkfuFNvCPN38wLOLwbZzeGU5YASsWCLynrq', 'Seller6', '1234567896'),
(9, 'seller7@email.com', '$2y$10$wRCTsz7YLwy0nR5EmTrp/Oj7H/WzQByhIxlckZebBN/tEiaQzBOiS', 'Seller7', '1234567897'),
(10, 'seller8@email.com', '$2y$10$fUGF25kfEOn6rKDkgfEZr.VHiLvYDUai3OyPUvsTi4OpiZ12LstMG', 'Seller8', '1234567898'),
(11, 'seller9@email.com', '$2y$10$SXNSn8Si7MN3w7LZp9byYuWeuVo5FjgVbUlPMc4MKcTxYbTpsaRV.', 'Seller9', '1234567899');

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcart_tags`
--

CREATE TABLE `shoppingcart_tags` (
  `id` int(11) NOT NULL,
  `tag` int(11) NOT NULL,
  `buyer` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `example` text NOT NULL,
  `example_desc` text NOT NULL,
  `seller` int(11) NOT NULL,
  `price` float NOT NULL,
  `sale_price` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `description`, `example`, `example_desc`, `seller`, `price`, `sale_price`) VALUES
(1, 'base', 'The <base> element is used to identify a base URL upon which to build all relative URLs that appear on a webpage. In addition, if the <base> element has a target attribute, the target attribute will be used as the default attribute for all hyperlinks appearing in the document.', '<html>\n <head>\n </head>\n <body>\n  <p>\n   <base href=\"https://www.w3schools.com/\" target=\"_blank\"/>\n  </p>\n  <img alt=\"Stickman\" height=\"39\" src=\"images/stickman.gif\" width=\"24\"/>\n  <a href=\"tags/tag_base.asp\">\n   HTML base Tag\n  </a>\n </body>\n</html>', 'Specify a default URL and a default target for all links on a page:', 1, 35.87, 35.33),
(2, 'link', 'The <link> element is used to define a relationship between an HTML document and an external resource. This element is most commonly used to define the relationship between a document and one or more external CSS stylesheets.', '<html>\n <head>\n </head>\n <body>\n  <p>\n   <link href=\"styles.css\" rel=\"stylesheet\"/>\n  </p>\n </body>\n</html>', 'Link to an external style sheet:', 1, 24.79, 6.47),
(3, 'meta', 'The <meta> element is used to add machine-readable information to an HTML document. Information added with the <meta> tag is not displayed to website visitors but is provided for use by browsers and web crawlers.', '<html>\n <head>\n </head>\n <body>\n  <p>\n   <meta charset=\"utf-8\"/>\n   <meta content=\"Free Web tutorials\" name=\"description\"/>\n   <meta content=\"HTML, CSS, JavaScript\" name=\"keywords\"/>\n   <meta content=\"John Doe\" name=\"author\"/>\n   <meta content=\"width=device-width, initial-scale=1.0\" name=\"viewport\"/>\n  </p>\n </body>\n</html>', 'Describe metadata within an HTML document:', 1, 20.92, 6.27),
(4, 'noscript', 'The <noscript> element contains HTML content that will be rendered if a user viewing the webpage does so using a browser that does not support scripts or has disabled scripts.', '<html>\n <head>\n  <script>\n   document.write(\"Hello World!\")\n  </script>\n  <noscript>\n   Your browser does not support JavaScript!\n  </noscript>\n </head>\n</html>', 'Use of the <noscript> tag:', 1, 18.85, 3.46),
(5, 'script', 'The <script> element contains code written in a programming language other than HTML or specifies the location of an external script resource. It is most commonly used to add JavaScript and jQuery to webpages either directly or by linking to external .js files.', '<html>\n <head>\n  <script>\n   document.getElementById(\"demo\").innerHTML = \"Hello JavaScript!\";\n  </script>\n </head>\n</html>', 'Write \"Hello JavaScript!\" with JavaScript:', 1, 19.69, 14.09),
(6, 'style', 'The <style> element is used to add CSS style rules to an HTML document. The element is expected to appear in the document <head>, but will also render acceptably when used in the <body> of the document.', '<html>\n <head>\n  <style>\n   h1 {color:red;}\n  \n p {color:blue;}\n  </style>\n </head>\n <body>\n  <h1>\n   A heading\n  </h1>\n  <p>\n   A paragraph.\n  </p>\n </body>\n</html>\n', 'Use of the <style> element to apply a simple style sheet to an HTML document:', 1, 18.2, NULL),
(7, 'title', 'The <title> element is a required HTML element used to assign a title to an HTML document. Page titles are not displayed in the browser window, but they are used as the page name by search engines and displayed by browsers in the title bar, on the page tab, and as the page name of bookmarked webpages.', '<!DOCTYPE html>\n<html>\n <head>\n </head>\n <body>\n  <p>\n  </p>\n  <title>\n   HTML Elements Reference\n  </title>\n  <h1>\n   This is a heading\n  </h1>\n  <p>\n   This is a paragraph.\n  </p>\n </body>\n</html>\n', 'Define a title for your HTML document:', 1, 39.78, NULL),
(8, 'abbr', 'The <abbr> element is used along with a title attribute to associate a full-text explanation with an abbreviation or acronym. Website visitors do not see the text in the title attribute, but browsers, search engines, and assistive technologies do use this information.', '<html>\n <body>\n  <p>\n   The\n   <abbr title=\"World Health Organization\">\n    WHO\n   </abbr>\n   was founded in 1948.\n  </p>\n </body>\n</html>', 'An abbreviation is marked up as follows:', 1, 28.21, 17.29),
(9, 'audio', 'The <audio> element is used to add audio media resources to an HTML document that will be played by native support for audio playback built into the browser rather than a browser plugin.', '<html>\n <body>\n  <audio controls=\"\">\n   <source src=\"horse.ogg\" type=\"audio/ogg\">\n    <source src=\"horse.mp3\" type=\"audio/mpeg\">\n     Your browser does not support the audio tag.\n    </source>\n   </source>\n  </audio>\n </body>\n</html>', 'Play a sound file:', 1, 0.88, NULL),
(10, 'b', 'The <b> element is used to draw attention to enclosed text without implying any added importance or emphasis. Text surrounded by <b> tags is displayed with a bold typeface.', '<html>\n <body>\n  <p>\n   This is normal text -\n   <b>\n    and this is bold text\n   </b>\n   .\n  </p>\n </body>\n</html>', 'Make some text bold (without marking it as important):', 1, 35.37, 0.12),
(11, 'bdo', 'The <bdo> element is used override the default directionality of text. It is used to display characters from languages that are read from right-to-left, such as Hebrew and Arabic.', '<html>\n <body>\n  <bdo dir=\"rtl\">\n   This text will go right-to-left.\n  </bdo>\n </body>\n</html>', 'Specify the text direction:', 1, 12.65, NULL),
(12, 'br', 'The <br> element is used to insert a line break or carriage-return within a parent element such as a paragraph without breaking out of the parent container.', '<html>\n <body>\n  <p>\n   To force\n   <br/>\n   line breaks\n   <br/>\n   in a text,\n   <br/>\n   use the br\n   <br/>\n   element.\n  </p>\n </body>\n</html>', 'Insert single line breaks in a text:', 1, 3.74, 0.63),
(13, 'button', 'The <button> element is used to create an HTML button. Any text appearing between the opening and closing tags will appear as text on the button. No action takes place by default when a button is clicked. Actions must be added to buttons using JavaScript or by associating the button with a form.', '<html>\n <body>\n  <button type=\"button\">\n   Click Me!\n  </button>\n </body>\n</html>', 'A clickable button is marked up as follows:', 1, 18.6, NULL),
(14, 'canvas', 'The <canvas> element creates a rectangular pane of arbitrary size which can be used for drawing graphics, manipulating photos, and creating animations with JavaScript.', '<html>\n <body>\n  <canvas id=\"myCanvas\">\n   Your browser \n    does not support the canvas tag.\n  </canvas>\n  <script>\n   var canvas = document.getElementById(\"myCanvas\");\n var ctx = canvas.getContext(\"2d\");\n ctx.fillStyle = \"#FF0000\";\n ctx.fillRect(0, 0, 80, 80);\n  </script>\n </body>\n</html>', 'Draw a red rectangle on the fly, and show it inside the <canvas> element:', 1, 3.12, 0.79),
(15, 'cite', 'The <cite> element identifies the source of a quotation or creative work. Use the element to identify the name rather than the author or creator of a referenced creative work.', '<html>\n <body>\n  <p>\n   <cite>\n    The Scream\n   </cite>\n   by Edward Munch. Painted in 1893.\n  </p>\n </body>\n</html>', 'Define the title of a work with the <cite> tag:', 1, 37.09, 20.43),
(16, 'code', 'The <code> element is used to define enclosed text as computer code. It is often paired with the <pre> element to preserve line breaks and indentation when presenting blocks of computer code.', '<html>\n <body>\n  <p>\n   The HTML\n   <code>\n    button\n   </code>\n   tag defines a clickable button.\n  </p>\n  <p>\n   The CSS\n   <code>\n    background-color\n   </code>\n   property defines the background color \n  of an element.\n  </p>\n </body>\n</html>', 'Define some text as computer code in a document:', 1, 38.16, 26.41),
(17, 'data', 'The <datalist> element is used to define autocompletion values for an associated <input> element. Suggested autocompletion values are added to a datalist by nesting one or more <option> elements between the opening and closing <datalist> tags.', '<html>\n <body>\n  <ul>\n   <li>\n    <data value=\"21053\">\n     Cherry \n  Tomato\n    </data>\n   </li>\n   <li>\n    <data value=\"21054\">\n     Beef \n  Tomato\n    </data>\n   </li>\n   <li>\n    <data value=\"21055\">\n     Snack \n  Tomato\n    </data>\n   </li>\n  </ul>\n </body>\n</html>', 'The following example displays product names but also associates each name \nwith a product number:', 1, 29.85, NULL),
(18, 'datalist', 'The <datalist> element is used to define autocompletion values for an associated <input> element. Suggested autocompletion values are added to a datalist by nesting one or more <option> elements between the opening and closing <datalist> tags.', '<html>\n <body>\n  <label for=\"browser\">\n   Choose your browser from the list:\n  </label>\n  <input id=\"browser\" list=\"browsers\" name=\"browser\"/>\n  <datalist id=\"browsers\">\n   <option value=\"Edge\">\n   </option>\n   <option value=\"Firefox\">\n   </option>\n   <option value=\"Chrome\">\n   </option>\n   <option value=\"Opera\">\n   </option>\n   <option value=\"Safari\">\n   </option>\n  </datalist>\n </body>\n</html>', 'A datalist with pre-defined options (connected to an <input> element):', 1, 8.03, 3.44),
(19, 'dfn', 'The <dfn> element is used to identify the defining instance of a term in an HTML document. When a term is wrapped in <dfn> tags, browsers and web crawlers will understand that nearby text contains a definition of the term.', '<html>\n <body>\n  <p>\n   <dfn>\n    HTML\n   </dfn>\n   is the standard markup language for creating web pages.\n  </p>\n </body>\n</html>', 'Mark up a term with <dfn>:', 1, 29.59, 8.14),
(20, 'em', 'The <em> element is used to indicate text that should receive greater emphasis than the surrounding text.', '<html>\n <body>\n  <p>\n   You\n   <em>\n    have\n   </em>\n   to hurry up!\n  </p>\n  <p>\n   We\n   <em>\n    cannot\n   </em>\n   live like \n  this.\n  </p>\n </body>\n</html>', 'Mark up emphasized text in a document:', 1, 6.18, NULL),
(21, 'embed', 'Was used to control the alignment of an embedded application. Not a part of the HTML specification.', '<html>\n <body>\n  <embed height=\"200\" src=\"pic_trulli.jpg\" type=\"image/jpg\" width=\"300\">\n  </embed>\n </body>\n</html>', 'An embedded image:', 1, 25.75, 19.32),
(22, 'i', 'The <i> element is used to differentiate words from the surrounding text by styling the marked text in italics without implying any added emphasis to the italicized words.', '<html>\n <body>\n  <p>\n   <i>\n    Lorem ipsum\n   </i>\n   is the most popular filler text in history.\n  </p>\n  <p>\n   The\n   <i>\n    RMS Titanic\n   </i>\n   , a luxury steamship, sank on April 15, 1912 \n    after striking an iceberg.\n  </p>\n </body>\n</html>', 'Mark up text that is set off from the normal prose in a document: ', 1, 37.98, 10.64),
(23, 'iframe', 'The <iframe> creates an inline frame, which embeds an independent HTML document into the current document.', '<html>\n <body>\n  <iframe src=\"https://www.w3schools.com\" title=\"W3Schools Free \n    Online Web Tutorials\">\n  </iframe>\n </body>\n</html>', 'An inline frame is marked up as follows:', 1, 32.51, 6.44),
(24, 'img', 'The <img> tag is used to insert an image into a document.', '<html>\n <body>\n  <img alt=\"Girl in a jacket\" height=\"600\" src=\"img_girl.jpg\" width=\"500\"/>\n </body>\n</html>', 'How to insert an image:', 1, 10.25, 5.48),
(25, 'input', 'The <input> element is used to create form fields that accept user input. Form <input> elements can be presented many different ways, including simple text fields, buttons, checkboxes, drop-down menus, and more, by setting the type attribute of the input element to the appropriate value.', '<html>\n <body>\n  <form action=\"/action_page.php\">\n   <label for=\"fname\">\n    First name:\n   </label>\n   <input id=\"fname\" name=\"fname\" type=\"text\"/>\n   <br/>\n   <br/>\n   <label for=\"lname\">\n    Last name:\n   </label>\n   <input id=\"lname\" name=\"lname\" type=\"text\"/>\n   <br/>\n   <br/>\n   <input type=\"submit\" value=\"Submit\"/>\n  </form>\n </body>\n</html>', 'An HTML form with three input fields; two text fields and one submit button:', 1, 24.22, 22.43),
(26, 'kbd', 'The <kbd> element is used to identify text that represents user keyboard input. Text surrounded by <kbd> tags is typically displayed in the browser\'s default monospace font.', '<html>\n <body>\n  <p>\n   Press\n   <kbd>\n    Ctrl\n   </kbd>\n   +\n   <kbd>\n    C\n   </kbd>\n   to copy text (Windows).\n  </p>\n  <p>\n   Press\n   <kbd>\n    Cmd\n   </kbd>\n   +\n   <kbd>\n    C\n   </kbd>\n   to copy text (Mac OS).\n  </p>\n </body>\n</html>', 'Define some text as keyboard input in a document:', 1, 11.46, 1.72),
(27, 'label', 'The <label> element is used to associate a text label with a form <input> field. The label is used to tell users the value that should be entered in the associated input field.', '<html>\n <body>\n  <form action=\"/action_page.php\">\n   <input id=\"html\" name=\"fav_language\" type=\"radio\" value=\"HTML\"/>\n   <label for=\"html\">\n    HTML\n   </label>\n   <br/>\n   <input id=\"css\" name=\"fav_language\" type=\"radio\" value=\"CSS\"/>\n   <label for=\"css\">\n    CSS\n   </label>\n   <br/>\n   <input id=\"javascript\" name=\"fav_language\" type=\"radio\" value=\"JavaScript\"/>\n   <label for=\"javascript\">\n    JavaScript\n   </label>\n   <br/>\n   <br/>\n   <input type=\"submit\" value=\"Submit\"/>\n  </form>\n </body>\n</html>', 'Three radio buttons with labels:', 1, 18.88, NULL),
(28, 'mark', 'The <mark> element is used to highlight text inside of another element such as a paragraph, list, or table. Text to which the <mark> element has been added is considered to be particularly relevant in a specific context.', '<html>\n <body>\n  <p>\n   Do not forget to buy\n   <mark>\n    milk\n   </mark>\n   today.\n  </p>\n </body>\n</html>', 'Highlight parts of a text:', 1, 2.54, 0.27),
(29, 'math', 'The MathML <math> tag in HTML5 is the most prioritize element. Whatever MathML element you want to use they should wrapped inside of the <math> tag.', '<html>\n <body>\n  <math>\n   <mrow>\n    <mrow>\n     <msup>\n      <mi>\n       x\n      </mi>\n      <mn>\n       2\n      </mn>\n     </msup>\n     <mo>\n      +\n     </mo>\n     <msup>\n      <mi>\n       y\n      </mi>\n      <mn>\n       2\n      </mn>\n     </msup>\n    </mrow>\n    <mo>\n     =\n    </mo>\n    <msup>\n     <mi>\n      z\n     </mi>\n     <mn>\n      2\n     </mn>\n    </msup>\n   </mrow>\n  </math>\n </body>\n</html>', 'Display a math formula:', 1, 21.34, NULL),
(30, 'meter', 'The <meter> element is used to show the user the relative progress of a task over time. The meter element is used to show progress in terms of numerical value.', '<html>\n <body>\n  <p>\n   <meter value=\"3\" min=\"0\" max=\"10\">3/10</meter>\n  </p>\n </body>\n</html>', 'Display a progress bar:', 1, 26.84, 5.05),
(31, 'object', 'The <object> element is used to embed external content into the document. The content can be from a different origin, such as a different web site or a different application. The <object> element can be used to embed any type of external content, including interactive content.', '<html>\n <body>\n  <object data=\"http://www.example.com/example.swf\" type=\"application/x-shockwave-flash\">\n   <param name=\"movie\" value=\"http://www.example.com/example.swf\"/>\n   <param name=\"quality\" value=\"high\"/>\n  </object>\n </body>\n</html>', 'Embed a Flash file:', 1, 22.28, NULL),
(32, 'output', 'The <output> element is used to display the result of a calculation or the result of a user-interaction.', '<html>\n <body>\n  <p>\n   <output name=\"result\">\n    3 + 4 = 7\n   </output>\n  </p>\n </body>\n</html>', 'Display the result of a calculation:', 1, 26.11, NULL),
(33, 'picture', 'The <picture> element is used to embed responsive images. The <picture> element is a container for other elements and semantics that can be used to represent images. The <picture> element is a container for other elements and semantics that can be used to represent images. The <picture> element is a container for other elements and semantics that can be used to represent images.', '<html>\n <body>\n  <p>\n   <picture>\n    <source srcset=\"/images/example.webp\" type=\"image/webp\">\n    <img src=\"/images/example.jpg\" alt=\"Example\"/>\n   </picture>\n  </p>\n </body>\n</html>', 'Embed a responsive image:', 1, 24.37, NULL),
(34, 'progress', 'The <progress> element is used to create a progress bar to serve as a visual demonstration of progress towards the completion of task or goal. The max and value attributes are used to define how much progress (value) has been made towards task completion (max).', '<html>\n <body>\n  <label for=\"file\">\n   Downloading progress:\n  </label>\n  <progress id=\"file\" max=\"100\" value=\"32\">\n   32%\n  </progress>\n </body>\n</html>', 'Show a progress bar:', 1, 6.31, NULL),
(35, 'q', 'The <q> element is used to identify and inline quote that does not require paragraph breaks. Longer quotations that do require paragraph breaks should use the <blockquote> element.', '<html>\n <body>\n  <p>\n   WWF\'s goal is to:\n   <q>\n    Build a future where people live in harmony with nature.\n   </q>\n   We hope they succeed.\n  </p>\n </body>\n</html>', 'Mark up a short quotation:', 1, 36.56, 1.64),
(36, 'ruby', 'The <ruby> element is used pair characters of certain Asian languages with pronunciation information. The <ruby> element is used in conjunction with the <rp> and <rt> elements.', '<html>\n <body>\n  <ruby>\n   漢\n   <rt>\n    ㄏㄢˋ\n   </rt>\n  </ruby>\n </body>\n</html>', 'A ruby annotation:', 1, 17.76, 12.69),
(37, 'samp', 'The <samp> element is used to identify text that should be interpreted as sample output from a computer program. By default, browser render <samp> element contents in a monospace font.', '<html>\n <body>\n  <p>\n   Message from my computer:\n  </p>\n  <p>\n   <samp>\n    File not found.\n    <br/>\n    Press \n      F1 to continue\n   </samp>\n  </p>\n </body>\n</html>', 'Define some text as sample output from a computer program in a document:', 1, 36.05, 31.27),
(38, 'select', 'The <select> element, used along with one or more <option> elements, creates a drop-down list of options for a web form. The <select> element creates the list and each <option> element is displayed as an available option in the list.', '<html>\n <body>\n  <label for=\"cars\">\n   Choose a car:\n  </label>\n  <select id=\"cars\" name=\"cars\">\n   <option value=\"volvo\">\n    Volvo\n   </option>\n   <option value=\"saab\">\n    Saab\n   </option>\n   <option value=\"mercedes\">\n    Mercedes\n   </option>\n   <option value=\"audi\">\n    Audi\n   </option>\n  </select>\n </body>\n</html>', 'Create a drop-down list with four options:', 1, 8.95, 2.04),
(39, 'small', 'The <small> element identifies text to display one size smaller than the surrounding text. In HTML5 the element is intended to be used to identify items of secondary importance such as copyright notices, side comments, and legal notices.', '<html>\n <body>\n  <p>\n   This is some normal text.\n  </p>\n  <p>\n   <small>\n    This is some smaller \n    text.\n   </small>\n  </p>\n </body>\n</html>', 'Define a smaller text:', 1, 33.04, NULL),
(40, 'span', 'The <span> element is the inline equivalent to the block-level <div> element. It is used to select inline content for purely stylistic purposes.', '<html>\n <body>\n  <p>\n   My mother has\n   <span style=\"color:blue\">\n    blue\n   </span>\n   eyes.\n  </p>\n </body>\n</html>', 'A <span> element which is used to color a part of a text:', 1, 17.52, NULL),
(41, 'strong', 'The <strong> element is used to identify text that is of greater importance than the surrounding text. By default, all browsers render <strong> text in a bold typeface.', '<html>\n <body>\n  <strong>\n   This text is important!\n  </strong>\n </body>\n</html>', 'Define important text in a document:', 1, 31.99, NULL),
(42, 'sub', 'The <sub> element is used to identify characters that should be rendered in a subscript position. The element should be used mark text according to typographical conventions and not stylistic purposes. Text that is to appear subscript for purely stylistic purposes should be styled with CSS.', '<html>\n <body>\n  <p>\n   This text contains\n   <sub>\n    subscript\n   </sub>\n   text.\n  </p>\n </body>\n</html>', 'Subscript text:', 1, 17.02, 12.62),
(43, 'sup', 'inlineUsagetextual', '<html>\n <body>\n  <p>\n   This text contains\n   <sup>\n    superscript\n   </sup>\n   text.\n  </p>\n </body>\n</html>', 'Superscript text:', 1, 13.96, 5.45),
(44, 'svg', 'The <svg> element is an SVG image. It can be included using the <object> element or by referencing a data URI.', '<html>\n <body>\n  <svg height=\"100\" width=\"100\">\n   <circle cx=\"50\" cy=\"50\" fill=\"yellow\" r=\"40\" stroke=\"green\" stroke-width=\"4\">\n   </circle>\n  </svg>\n </body>\n</html>', 'Draw a circle:', 1, 9.09, NULL),
(45, 'textarea', 'The <textarea> element is used to create a text input area of unlimited length. By default, text in a <textarea> is rendered in a monospace or fixed-width font, and text areas are most often used within a parent <form> element.', '<html>\n <body>\n  <label for=\"w3review\">\n   Review of W3Schools:\n  </label>\n  <textarea cols=\"50\" id=\"w3review\" name=\"w3review\" rows=\"4\">\n      At w3schools.com you will learn how to make a website. They offer free tutorials in all web development technologies. \n      </textarea>\n </body>\n</html>', 'A multi-line text input control (text area):', 1, 38.52, 14.64),
(46, 'time', 'The <time> element represents either an HTML5 time element or an HTML5 date-time element. The HTML5 time element is used to output either a time or a date and time, and the HTML5 date-time element is used to output a date and time.', '<html>\n <body>\n  <p>\n   Open from\n   <time>\n    10:00\n   </time>\n   to\n   <time>\n    21:00\n   </time>\n   every weekday.\n  </p>\n  <p>\n   I have a date on\n   <time datetime=\"2008-02-14 20:00\">\n    Valentines day\n   </time>\n   .\n  </p>\n </body>\n</html>', 'How to define a time and a date:', 1, 2.59, 0.82),
(47, 'u', 'The <u> element was originally used to identify text that should be underlined. The element was deprecated in HTML 4.01, but in HTML5 it was redefined to represent text that should be displayed in a way that is an unarticulated but stylistically distinct from the surrounding text. For example, one proper use of the <u> element is to identify misspelled terms.', '<html>\n <body>\n  <p>\n   This is some\n   <u>\n    mispeled\n   </u>\n   text.\n  </p>\n </body>\n</html>', 'Mark up a misspelled word with the <u> tag:', 1, 25.86, NULL),
(48, 'var', 'The <var> element is used to identify a variable in a mathematical equation or computer program. Text marked with <var> tags is displayed in an italics font style by most browsers.', '<html>\n <body>\n  <p>\n   The area of a triangle is: 1/2 x\n   <var>\n    b\n   </var>\n   x\n   <var>\n    h\n   </var>\n   , where\n   <var>\n    b\n   </var>\n   is the base, and\n   <var>\n    h\n   </var>\n   is the vertical height.\n  </p>\n </body>\n</html>', 'Define some text as variables in a document:', 1, 38.38, 5.4),
(49, 'video', 'The <video> element, which adds native video playback support to the HTML specification in HTML5, can be used to embed a video in an HTML document. Add the video URL to the element by using either the src attribute of the <video> element or by nesting one or more <source> elements between the opening and closing <video> tags.', '<html>\n <body>\n  <video controls=\"\" height=\"240\" width=\"320\">\n   <source src=\"movie.mp4\" type=\"video/mp4\">\n    <source src=\"movie.ogg\" type=\"video/ogg\">\n     Your browser does not support the video tag.\n    </source>\n   </source>\n  </video>\n </body>\n</html>', 'Play a video:', 1, 23.14, NULL),
(50, 'wbr', 'The <wbr> element is used to define a word break opportunity in a string of text. It is particularly useful when you wish to define word break opportunities in a long unbroken string of text that might otherwise break improperly.', '<html>\n <body>\n  <p>\n   To learn AJAX, you must be familiar with the XML\n   <wbr>\n    Http\n    <wbr>\n     Request Object.\n    </wbr>\n   </wbr>\n  </p>\n </body>\n</html>', 'A text with word break opportunities:', 1, 18.38, 4.43),
(51, 'a', 'The <a> element, or anchor element, it used to create a hyperlink to another webpage or another location within the same webpage. The hyperlink created by an anchor element is applied to the text, image, or other HTML content nested between the opening and closing <a> tags.', '<html>\n <body>\n  <a href=\"https://www.w3schools.com\">\n   Visit W3Schools.com!\n  </a>\n </body>\n</html>', 'Create a link to W3Schools.com:', 1, 17.13, 14.04),
(52, 'area', 'The <area> element is used as a child of a <map> element to define clickable a region on an image map. Different regions of an image map can be hyperlinked to different locations by nesting multiple <area> elements in a single <map> element.', '<html>\n <body>\n  <img alt=\"Workplace\" height=\"379\" src=\"workplace.jpg\" usemap=\"#workmap\" width=\"400\"/>\n  <map name=\"workmap\">\n   <area alt=\"Computer\" coords=\"34,44,270,350\" href=\"computer.htm\" shape=\"rect\"/>\n   <area alt=\"Phone\" coords=\"290,172,333,250\" href=\"phone.htm\" shape=\"rect\"/>\n   <area alt=\"Cup of coffee\" coords=\"337,300,44\" href=\"coffee.htm\" shape=\"circle\"/>\n  </map>\n </body>\n</html>', 'An image map, with clickable areas:', 1, 9.47, NULL),
(53, 'del', 'The <del> tag is used to identify text that has been deleted from a document but retained to show the history of modifications made to the document. Pair a <del> element with an <ins> element to identify the inserted text that replaced the deleted text.', '<html>\n <body>\n  <p>\n   My favorite color is\n   <del>\n    blue\n   </del>\n   <ins>\n    red\n   </ins>\n   !\n  </p>\n </body>\n</html>', 'A text with a deleted part, and a new, inserted part:', 1, 14.2, 7.07),
(54, 'ins', 'The <ins> element is used to identify text that has been inserted into a document. It is often paired with a <del> element which identifies deleted text replaced by the text contained in the <ins> element.', '<html>\n <body>\n  <p>\n   My favorite color is\n   <del>\n    blue\n   </del>\n   <ins>\n    red\n   </ins>\n   !\n  </p>\n </body>\n</html>', 'A text with a deleted part, and a new, inserted part:', 1, 18.34, 12.45),
(55, 'map', 'The <map> element is used in conjunction with one or more <area> elements to define hyperlinked regions of an image map.', '<html>\n <body>\n  <img alt=\"Workplace\" height=\"379\" src=\"workplace.jpg\" usemap=\"#workmap\" width=\"400\"/>\n  <map name=\"workmap\">\n   <area alt=\"Computer\" coords=\"34,44,270,350\" href=\"computer.htm\" shape=\"rect\"/>\n   <area alt=\"Phone\" coords=\"290,172,333,250\" href=\"phone.htm\" shape=\"rect\"/>\n   <area alt=\"Cup of coffee\" coords=\"337,300,44\" href=\"coffee.htm\" shape=\"circle\"/>\n  </map>\n </body>\n</html>', 'An image map, with clickable areas:', 1, 16.65, NULL),
(56, 'h1', 'The <h1> element defines a heading level 1. It is a paragraph-level semantic element, and as such, it is typically treated as a block-level element.', '<html>\n <body>\n  <h1>\n   Heading 1\n  </h1>\n </body>\n</html>', 'Heading 1:', 1, 10.27, NULL),
(57, 'h2', 'The <h2> element defines a heading level 2. It is a paragraph-level semantic element, and as such, it is typically treated as a block-level element.', '<html>\n <body>\n  <h2>\n   Heading 2\n  </h2>\n </body>\n</html>', 'Heading 2:', 1, 21.1, NULL),
(58, 'h3', 'The <h3> element defines a heading level 3. It is a paragraph-level semantic element, and as such, it is typically treated as a block-level element.', '<html>\n <body>\n  <h3>\n   Heading 3\n  </h3>\n </body>\n</html>', 'Heading 3:', 1, 32.19, 24.7),
(59, 'h4', 'The <h4> element defines a heading level 4. It is a paragraph-level semantic element, and as such, it is typically treated as a block-level element.', '<html>\n <body>\n  <h4>\n   Heading 4\n  </h4>\n </body>\n</html>', 'Heading 4:', 1, 36.08, 15.53),
(60, 'h5', 'The <h5> element defines a heading level 5. It is a paragraph-level semantic element, and as such, it is typically treated as a block-level element.', '<html>\n <body>\n  <h5>\n   Heading 5\n  </h5>\n </body>\n</html>', 'Heading 5:', 1, 17.48, NULL),
(61, 'h6', 'The <h6> element defines a heading level 6. It is a paragraph-level semantic element, and as such, it is typically treated as a block-level element.', '<html>\n <body>\n  <h6>\n   Heading 6\n  </h6>\n </body>\n</html>', 'Heading 6:', 1, 21.36, NULL),
(62, 'hgroup', 'The <hgroup> element is used to group a set of <h1> to <h6> elements for formatting purposes.', '<html>\n <body>\n  <hgroup>\n   <h1>\n    Heading 1\n   </h1>\n   <h2>\n    Heading 2\n   </h2>\n   <h3>\n    Heading 3\n   </h3>\n   <h4>\n    Heading 4\n   </h4>\n   <h5>\n    Heading 5\n   </h5>\n   <h6>\n    Heading 6\n   </h6>\n  </hgroup>\n </body>\n</html>', 'Heading groups:', 1, 9.74, 6.16),
(63, 'address', 'The <address> element is a generic address element. It is typically used to give the name and contact details for the person responsible for the page.', '<html>\n <body>\n  <address>\n   Contact:\n   <a href=\"mailto: test@email.com\"></a>\n  </address>\n </body>\n</html>', 'An address:', 1, 4.24, NULL),
(64, 'article', 'The <article> element represents a self-contained composition in a document, page, application, or site, which is intended to be independently distributable or reusable. Examples include: a forum post, a magazine article, a blog entry, a user-submitted comment, and a proposed article.', '<html>\n <body>\n  <article>\n   <h1>\n    Example heading\n   </h1>\n   <p>\n    Example paragraph\n   </p>\n  </article>\n </body>\n</html>', 'An article:', 1, 18.72, NULL),
(65, 'aside', 'The <aside> element represents a section of a document that is not a primary part of the document, but is related to the document\'s main content. Asides may contain any kind of content, including other sections.', '<html>\n <body>\n  <aside>\n   <h1>\n    Example heading\n   </h1>\n   <p>\n    Example paragraph\n   </p>\n  </aside>\n </body>\n</html>', 'An aside:', 1, 21.59, NULL),
(66, 'bdi', 'The <bdi> element represents a span of text that is isolated from its surrounding for the purposes of bidirectional text formatting. [MDN]', '<html>\n <body>\n  <p>\n   <bdi>\n    <span>\n     This text is isolated\n    </span>\n   </bdi>\n  </p>\n </body>\n</html>', 'Isolated text:', 1, 17.02, NULL),
(67, 'blockquote', 'The <blockquote> element defines a block of text that is a direct quotation. The <quote> element should be used when a quotation is presented inline with the surrounding text, but when the quotation is presented as a separate paragraph, <blockquote> is the appropriate element to use to identify the quotation.', '<html>\n <body>\n  <blockquote cite=\"http://www.worldwildlife.org/who/index.html\">\n   For 50 years, WWF has been protecting the future of nature. The world\'s leading conservation organization, WWF works in 100 countries and is supported by 1.2 million members in the United States and close to 5 million globally.\n  </blockquote>\n </body>\n</html>', 'A section that is quoted from another source:', 1, 26.66, NULL),
(68, 'details', 'The <details> element is used to pair a <summary> statement with additional related details. The <summary> is displayed, and a user can view or hide additional details by clicking on the summary.', '<html>\n <body>\n  <details>\n   <summary>\n    Epcot Center\n   </summary>\n   <p>\n    Epcot is a \n    theme park at Walt Disney World Resort featuring exciting attractions, \n    international pavilions, award-winning fireworks and seasonal special \n    events.\n   </p>\n  </details>\n </body>\n</html>', 'Specify details that the user can open and close on demand:', 1, 18.35, NULL),
(69, 'div', 'The <div> element defines an arbitrary block of content which can be placed and styled as a single unit.', '<html>\n <head>\n  <style>\n   .myDiv {  border: 5px outset red;  \n  background-color: lightblue;   text-align: center;}\n  </style>\n </head>\n <body>\n  <div class=\"myDiv\">\n   <h2>\n    This is a heading \n  in a div element\n   </h2>\n   <p>\n    This is some text in a div element.\n   </p>\n  </div>\n </body>\n</html>\n', 'A <div> section in a document that is styled with CSS:', 1, 21.97, 10.51),
(70, 'dl', 'The <dl> element defines a description list.', '<html>\n <body>\n  <dl>\n   <dt>\n    Coffee\n   </dt>\n   <dd>\n    Black hot drink\n   </dd>\n   <dt>\n    Milk\n   </dt>\n   <dd>\n    White cold drink\n   </dd>\n  </dl>\n </body>\n</html>', 'A description list, with terms and descriptions:', 1, 1.44, 0.93),
(71, 'fieldset', 'The <fieldset> element may be optionally used to group together related fields in an HTML form.', '<html>\n <body>\n  <form action=\"/action_page.php\">\n   <fieldset>\n    <legend>\n     Personalia:\n    </legend>\n    <label for=\"fname\">\n     First \n    name:\n    </label>\n    <input id=\"fname\" name=\"fname\" type=\"text\"/>\n    <br/>\n    <br/>\n    <label for=\"lname\">\n     Last name:\n    </label>\n    <input id=\"lname\" name=\"lname\" type=\"text\"/>\n    <br/>\n    <br/>\n    <label for=\"email\">\n     Email:\n    </label>\n    <input id=\"email\" name=\"email\" type=\"email\"/>\n    <br/>\n    <br/>\n    <label for=\"birthday\">\n     Birthday:\n    </label>\n    <input id=\"birthday\" name=\"birthday\" type=\"date\"/>\n    <br/>\n    <br/>\n    <input type=\"submit\" value=\"Submit\"/>\n   </fieldset>\n  </form>\n </body>\n</html>', 'Group related elements in a form:', 1, 5.68, 3.41),
(72, 'figure', 'The <figure> element identifies self-contained content related to the main content, such as an image, table, or chart. The <figcaption> element is often nested within a <figure> element to add a caption to the content identified by the <figure> tags.', '<html>\n <body>\n  <figure>\n   <img alt=\"Trulli\" src=\"pic_trulli.jpg\" style=\"width:100%\"/>\n   <figcaption>\n    Fig.1 - Trulli, Puglia, \n    Italy.\n   </figcaption>\n  </figure>\n </body>\n</html>', 'Use a <figure> element to mark up a photo in a document, and a <figcaption> \nelement to define a caption for the photo:', 1, 21.66, 3.93),
(73, 'footer', 'The <footer> element is a structural element used to identify the footer of a page, document, article, or section. A <footer> typically contains copyright and authorship information or navigational elements pertaining to the contents of the parent element.', '<html>\n <body>\n  <footer>\n   <p>\n    Author: Hege Refsnes\n   </p>\n   <p>\n    <a href=\"mailto:hege@example.com\">\n     hege@example.com\n    </a>\n   </p>\n  </footer>\n </body>\n</html>', 'A footer section in a document:', 1, 27.06, 24.63),
(74, 'form', 'The <form> element is used to create an HTML form. The <form> element does not actually create form fields, but is used as a parent container to hold form fields such as <input> and <textarea> elements.', '<html>\n <body>\n  <form action=\"/action_page.php\" method=\"get\">\n   <label for=\"fname\">\n    First name:\n   </label>\n   <input id=\"fname\" name=\"fname\" type=\"text\"/>\n   <br/>\n   <br/>\n   <label for=\"lname\">\n    Last name:\n   </label>\n   <input id=\"lname\" name=\"lname\" type=\"text\"/>\n   <br/>\n   <br/>\n   <input type=\"submit\" value=\"Submit\"/>\n  </form>\n </body>\n</html>', 'An HTML form with two input fields and one submit button:', 1, 13.88, NULL),
(75, 'header', 'The <header> element is used to identify content that precedes the primary content of the web page and often contains website branding, navigation elements, search forms, and similar content that is duplicated across all or most pages of a website.', '<html>\n <body>\n  <article>\n   <header>\n    <h1>\n     A heading here\n    </h1>\n    <p>\n     Posted by John \n    Doe\n    </p>\n    <p>\n     Some additional information here\n    </p>\n   </header>\n   <p>\n    Lorem Ipsum dolor set amet....\n   </p>\n  </article>\n </body>\n</html>', 'A header for an <article>:', 1, 4.29, 1.45),
(76, 'hr', 'The <hr> element is used to represent a thematic break between paragraph-level elements. It is typically rendered as a horizontal line.', '<html>\n <body>\n  <h1>\n   The Main Languages of the Web\n  </h1>\n  <p>\n   HTML is the standard markup \n    language for creating Web pages. HTML describes the structure of a Web page, \n    and consists of a series of elements. HTML elements tell the browser how to \n    display the content.\n  </p>\n  <hr/>\n  <p>\n   CSS is a language that \n    describes how HTML elements are to be displayed on screen, paper, or in \n    other media. CSS saves a lot of work, because it can control the layout of \n    multiple web pages all at once.\n  </p>\n  <hr/>\n  <p>\n   JavaScript is the \n    programming language of HTML and the Web. JavaScript can change HTML content \n    and attribute values. JavaScript can change CSS. JavaScript can hide and \n    show HTML elements, and more.\n  </p>\n </body>\n</html>', 'Use the <hr> tag to define thematic changes in the content:', 1, 34.17, 27.47),
(77, 'main', 'The <main> element is used to denote the content of a webpage that relates to the central topic of that page or application. It should include content that is unique to that page and should not include content that is duplicated across multiple webpages, such as headers, footers, and primary navigation elements.', '<html>\n <body>\n  <main>\n   <h1>\n    Most Popular Browsers\n   </h1>\n   <p>\n    Chrome, Firefox, and \n    Edge are the most used browsers today.\n   </p>\n   <article>\n    <h2>\n     Google Chrome\n    </h2>\n    <p>\n     Google Chrome is a web browser \n  developed by Google, released in 2008. Chrome is the world\'s most popular web \n  browser today!\n    </p>\n   </article>\n   <article>\n    <h2>\n     Mozilla \n  Firefox\n    </h2>\n    <p>\n     Mozilla Firefox is an open-source web browser developed by \n  Mozilla. Firefox has been the second most popular web browser since January, \n  2018.\n    </p>\n   </article>\n   <article>\n    <h2>\n     Microsoft Edge\n    </h2>\n    <p>\n     Microsoft Edge is a web browser developed by Microsoft, released in 2015. \n  Microsoft Edge replaced Internet Explorer.\n    </p>\n   </article>\n  </main>\n </body>\n</html>', 'Specify the main content of the document:', 1, 24.06, NULL),
(78, 'menu', 'The <menu> element defines an instance of a menu. This experimental HTML feature has very limited browser support, but may soon be an effective way to add menu items to context menus and to create interactive web application menus.', '<html>\n <body>\n  <menu id=\"mymenu\" type=\"context\">\n   <menuitem icon=\"ico_reload.png\" label=\"Refresh\" onclick=\"window.location.reload();\">\n   </menuitem>\n   <menu label=\"Share on...\">\n    <menuitem icon=\"ico_twitter.png\" label=\"Twitter\" onclick=\"window.open(\'//twitter.com/intent/tweet?text=\'+window.location.href);\">\n    </menuitem>\n    <menuitem icon=\"ico_facebook.png\" label=\"Facebook\" onclick=\"window.open(\'//facebook.com/sharer/sharer.php?u=\'+window.location.href);\">\n    </menuitem>\n   </menu>\n   <menuitem label=\"Email This Page\" onclick=\"window.location=\'mailto:?body=\'+window.location.href;\"/>\n  </menu>\n </body>\n</html>', 'A context menu with different <menuitem> elements:', 1, 21.08, NULL),
(79, 'nav', 'The <nav> element identifies a group of navigation links. Links in a <nav> element may point to other webpages or to different sections of the same webpage.', '<html>\n <body>\n  <nav>\n   <a href=\"/html/\">\n    HTML\n   </a>\n   |\n   <a href=\"/css/\">\n    CSS\n   </a>\n   |\n   <a href=\"/js/\">\n    JavaScript\n   </a>\n   |\n   <a href=\"/python/\">\n    Python\n   </a>\n  </nav>\n </body>\n</html>', 'A set of navigation links:', 1, 3.44, 1.04),
(80, 'ol', 'The <ol> element is used to create an ordered list. An ordered list is created by nesting one or more <li> elements between the opening and closing <ol> tags.', '<html>\n <body>\n  <ol>\n   <li>\n    Coffee\n   </li>\n   <li>\n    Tea\n   </li>\n   <li>\n    Milk\n   </li>\n  </ol>\n  <ol start=\"50\">\n   <li>\n    Coffee\n   </li>\n   <li>\n    Tea\n   </li>\n   <li>\n    Milk\n   </li>\n  </ol>\n </body>\n</html>', 'Two different ordered lists (the first list starts at 1, and the second \nstarts at 50):', 1, 33.66, NULL),
(81, 'p', 'The <p> element is used to identify blocks of paragraph text. The closing <p> tag is optional and is implied by the opening tag of the next HTML element encountered in an HTML document after an opening <p> tag.', '<html>\n <body>\n  <p>\n   This is some text in a paragraph.\n  </p>\n </body>\n</html>', 'A paragraph is marked up as follows:', 1, 11.76, 6.08),
(82, 'pre', 'The <pre> element is used to identify text that should be rendered with all line breaks and spaces intact. It is often used to preserve indenting and line breaks when displaying code blocks.', '<html>\n <body>\n  <pre>\n      Text in a pre element\n  is displayed in a fixed-width\n font, and it preserves\n both     \n      spaces and\n line breaks\n      </pre>\n </body>\n</html>', 'Preformatted text:', 1, 32.24, 5.76),
(83, 's', 'The <s> element is used to identify text that is no longer accurate or relevant. It is similar to, but semantically distinct from, the <del> element which is used to identify document edits. By default, browsers render the contents of an <s> element with a strikethrough.', '<html>\n <body>\n  <p>\n   <s>\n    Only 50 tickets left!\n   </s>\n  </p>\n  <p>\n   SOLD OUT!\n  </p>\n </body>\n</html>', 'Mark up text that is no longer correct:', 1, 29.85, 23.31),
(84, 'section', 'The <section> element is a structural HTML element used to group together related elements. Each <section> typically includes one or more heading elements and additional elements presenting related content.', '<html>\n <body>\n  <section>\n   <h2>\n    WWF History\n   </h2>\n   <p>\n    The World Wide Fund for Nature (WWF) \n    is an international organization working on issues regarding the \n    conservation, research and restoration of the environment, formerly named \n    the World Wildlife Fund. WWF was founded in 1961.\n   </p>\n  </section>\n  <section>\n   <h2>\n    WWF\'s Symbol\n   </h2>\n   <p>\n    The Panda has become the symbol of \n    WWF. The well-known panda logo of WWF originated from a panda named Chi Chi \n    that was transferred from the Beijing Zoo to the London Zoo in the same year \n    of the establishment of WWF.\n   </p>\n  </section>\n </body>\n</html>', 'Two sections in a document:', 1, 35.27, 2.85),
(85, 'table', 'The <table> element is used in conjunction with child elements such as <tr>, <td>, <th>, and others to add tabular data to an HTML document.', '<html>\n <body>\n  <table>\n   <tr>\n    <th>\n     Month\n    </th>\n    <th>\n     Savings\n    </th>\n   </tr>\n   <tr>\n    <td>\n     January\n    </td>\n    <td>\n     $100\n    </td>\n   </tr>\n  </table>\n </body>\n</html>', 'A simple HTML table, containing two columns and two rows:', 1, 28.94, NULL),
(86, 'template', 'The <template> element is used to wrap content that needs to be inserted into the document, but that is not part of the document\'s main flow.', '<html>\n <body>\n  <button onclick=\"showContent()\">\n   Show hidden content\n  </button>\n  <template>\n   <h2>\n    Flower\n   </h2>\n   <img height=\"204\" src=\"img_white_flower.jpg\" width=\"214\"/>\n  </template>\n  <script>\n   function showContent() {  var temp = \n  document.getElementsByTagName(\"template\")[0];  var clon = \n  temp.content.cloneNode(true);  document.body.appendChild(clon);}\n  </script>\n </body>\n</html>', 'Use <template> to hold some content that will be hidden when the page \nloads. Use JavaScript to display it:', 1, 0.87, 0.33),
(87, 'ul', 'The <ul> element is used to define an unordered list of items. Use an unordered list to contain <li> elements that do not need to be presented in numerical order and can be rearranged without changing the meaning of the list.', '<html>\n <body>\n  <ul>\n   <li>\n    Coffee\n   </li>\n   <li>\n    Tea\n   </li>\n   <li>\n    Milk\n   </li>\n  </ul>\n </body>\n</html>', 'An unordered HTML list:', 1, 17.24, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tag_categories`
--

CREATE TABLE `tag_categories` (
  `id` int(11) NOT NULL,
  `tag` int(11) NOT NULL,
  `category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tag_categories`
--

INSERT INTO `tag_categories` (`id`, `tag`, `category`) VALUES
(1, 1, 7),
(4, 2, 1),
(3, 2, 2),
(2, 2, 7),
(7, 3, 1),
(6, 3, 2),
(5, 3, 7),
(10, 4, 1),
(9, 4, 2),
(8, 4, 7),
(13, 5, 1),
(12, 5, 2),
(11, 5, 7),
(15, 6, 1),
(14, 6, 7),
(16, 7, 7),
(18, 8, 1),
(17, 8, 2),
(20, 9, 1),
(19, 9, 2),
(21, 9, 3),
(22, 9, 4),
(24, 10, 1),
(23, 10, 2),
(26, 11, 1),
(25, 11, 2),
(28, 12, 1),
(27, 12, 2),
(30, 13, 1),
(29, 13, 2),
(31, 13, 3),
(33, 14, 1),
(32, 14, 2),
(34, 14, 4),
(36, 15, 1),
(35, 15, 2),
(38, 16, 1),
(37, 16, 2),
(40, 17, 1),
(39, 17, 2),
(42, 18, 1),
(41, 18, 2),
(44, 19, 1),
(43, 19, 2),
(46, 20, 1),
(45, 20, 2),
(48, 21, 1),
(47, 21, 2),
(49, 21, 3),
(50, 21, 4),
(52, 22, 1),
(51, 22, 2),
(54, 23, 1),
(53, 23, 2),
(55, 23, 3),
(56, 23, 4),
(58, 24, 1),
(57, 24, 2),
(59, 24, 3),
(60, 24, 4),
(62, 25, 1),
(61, 25, 2),
(63, 25, 3),
(65, 26, 1),
(64, 26, 2),
(67, 27, 1),
(66, 27, 2),
(68, 27, 3),
(70, 28, 1),
(69, 28, 2),
(72, 29, 1),
(71, 29, 2),
(73, 29, 4),
(75, 30, 1),
(74, 30, 2),
(77, 31, 1),
(76, 31, 2),
(78, 31, 3),
(79, 31, 4),
(81, 32, 1),
(80, 32, 2),
(83, 33, 1),
(82, 33, 2),
(84, 33, 4),
(86, 34, 1),
(85, 34, 2),
(88, 35, 1),
(87, 35, 2),
(90, 36, 1),
(89, 36, 2),
(92, 37, 1),
(91, 37, 2),
(94, 38, 1),
(93, 38, 2),
(95, 38, 3),
(97, 39, 1),
(96, 39, 2),
(99, 40, 1),
(98, 40, 2),
(101, 41, 1),
(100, 41, 2),
(103, 42, 1),
(102, 42, 2),
(105, 43, 1),
(104, 43, 2),
(107, 44, 1),
(106, 44, 2),
(108, 44, 4),
(110, 45, 1),
(109, 45, 2),
(111, 45, 3),
(113, 46, 1),
(112, 46, 2),
(115, 47, 1),
(114, 47, 2),
(117, 48, 1),
(116, 48, 2),
(119, 49, 1),
(118, 49, 2),
(120, 49, 3),
(121, 49, 4),
(123, 50, 1),
(122, 50, 2),
(125, 51, 1),
(124, 51, 2),
(126, 51, 3),
(128, 52, 1),
(127, 52, 2),
(130, 53, 1),
(129, 53, 2),
(132, 54, 1),
(131, 54, 2),
(134, 55, 1),
(133, 55, 2),
(136, 56, 1),
(135, 56, 6),
(138, 57, 1),
(137, 57, 6),
(140, 58, 1),
(139, 58, 6),
(142, 59, 1),
(141, 59, 6),
(144, 60, 1),
(143, 60, 6),
(146, 61, 1),
(145, 61, 6),
(148, 62, 1),
(147, 62, 6),
(149, 63, 1),
(150, 64, 1),
(151, 64, 5),
(152, 65, 1),
(153, 65, 5),
(154, 66, 1),
(155, 67, 1),
(156, 68, 1),
(157, 68, 3),
(158, 69, 1),
(159, 70, 1),
(160, 71, 1),
(161, 72, 1),
(162, 73, 1),
(163, 74, 1),
(164, 75, 1),
(165, 76, 1),
(166, 77, 1),
(167, 78, 1),
(168, 78, 3),
(169, 79, 1),
(170, 79, 5),
(171, 80, 1),
(172, 81, 1),
(173, 82, 1),
(174, 83, 1),
(175, 84, 1),
(176, 84, 5),
(177, 85, 1),
(178, 86, 1),
(179, 87, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `buyer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist_tags`
--

CREATE TABLE `wishlist_tags` (
  `id` int(11) NOT NULL,
  `tag` int(11) NOT NULL,
  `wishlist` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buyers`
--
ALTER TABLE `buyers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order` (`order`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buyer` (`buyer`);

--
-- Indexes for table `order_tags`
--
ALTER TABLE `order_tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tag` (`tag`,`order`),
  ADD KEY `order` (`order`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order` (`order`);

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `rag_soc` (`rag_soc`);

--
-- Indexes for table `shoppingcart_tags`
--
ALTER TABLE `shoppingcart_tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tag` (`tag`,`buyer`),
  ADD KEY `buyer` (`buyer`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `seller` (`seller`);

--
-- Indexes for table `tag_categories`
--
ALTER TABLE `tag_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tag` (`tag`,`category`),
  ADD KEY `category` (`category`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `buyer` (`buyer`,`name`);

--
-- Indexes for table `wishlist_tags`
--
ALTER TABLE `wishlist_tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tag` (`tag`,`wishlist`),
  ADD KEY `wishlist` (`wishlist`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buyers`
--
ALTER TABLE `buyers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_tags`
--
ALTER TABLE `order_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sellers`
--
ALTER TABLE `sellers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `shoppingcart_tags`
--
ALTER TABLE `shoppingcart_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `tag_categories`
--
ALTER TABLE `tag_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlist_tags`
--
ALTER TABLE `wishlist_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`order`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`buyer`) REFERENCES `buyers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_tags`
--
ALTER TABLE `order_tags`
  ADD CONSTRAINT `order_tags_ibfk_1` FOREIGN KEY (`tag`) REFERENCES `tags` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_tags_ibfk_2` FOREIGN KEY (`order`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shoppingcart_tags`
--
ALTER TABLE `shoppingcart_tags`
  ADD CONSTRAINT `shoppingcart_tags_ibfk_1` FOREIGN KEY (`tag`) REFERENCES `tags` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shoppingcart_tags_ibfk_2` FOREIGN KEY (`buyer`) REFERENCES `buyers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `tags_ibfk_1` FOREIGN KEY (`seller`) REFERENCES `sellers` (`id`);

--
-- Constraints for table `tag_categories`
--
ALTER TABLE `tag_categories`
  ADD CONSTRAINT `tag_categories_ibfk_1` FOREIGN KEY (`tag`) REFERENCES `tags` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tag_categories_ibfk_2` FOREIGN KEY (`category`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_ibfk_1` FOREIGN KEY (`buyer`) REFERENCES `buyers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlist_tags`
--
ALTER TABLE `wishlist_tags`
  ADD CONSTRAINT `wishlist_tags_ibfk_1` FOREIGN KEY (`tag`) REFERENCES `tags` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_tags_ibfk_2` FOREIGN KEY (`wishlist`) REFERENCES `wishlists` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
