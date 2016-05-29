<?php

/* tickets.html */
class __TwigTemplate_52879652d515f47e27158e34fcd26c504feeccc3d0c1d4643e57616e9961cb0e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
\t<meta charset=\"UTF-8\">
\t<title>Document</title>
</head>
<body>
\t<h1>";
        // line 8
        echo twig_escape_filter($this->env, (isset($context["tickets"]) ? $context["tickets"] : null), "html", null, true);
        echo "</h1>
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "tickets.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  28 => 8,  19 => 1,);
    }
}
/* <!DOCTYPE html>*/
/* <html lang="en">*/
/* <head>*/
/* 	<meta charset="UTF-8">*/
/* 	<title>Document</title>*/
/* </head>*/
/* <body>*/
/* 	<h1>{{ tickets }}</h1>*/
/* </body>*/
/* </html>*/
