<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
?>
<div class="bs-docs-section">
	<p class="lead">
		Esse manual visa instruir novos usuários sobre a ultilização do desse sistema e também servir como fonte de conhecimento para as operações necessárias para oparacionalização do mesmo por completo, esse manual não substitui um completo treinamento de ultilização dos módulos e funções. 
		<a href="#grid-example-basic">predefined classes</a> 
		for easy layout options, as well as powerful 
		<a href="#grid-less">mixins for generating more semantic layouts</a>.
	</p>

  <h2 id="grid-intro"><a class="anchorjs-link " href="#grid-intro" aria-label="Anchor link for: grid intro" data-anchorjs-icon="" style="font-family: anchorjs-icons; font-style: normal; font-variant: normal; font-weight: normal; position: absolute; margin-left: -1em; padding-right: 0.5em;"></a>Introduction</h2>
  <p>Grid systems are used for creating page layouts through a series of rows and columns that house your content. Here's how the Bootstrap grid system works:</p>
  <ul>
    <li>Rows must be placed within a <code>.container</code> (fixed-width) or <code>.container-fluid</code> (full-width) for proper alignment and padding.</li>
    <li>Use rows to create horizontal groups of columns.</li>
    <li>Content should be placed within columns, and only columns may be immediate children of rows.</li>
    <li>Predefined grid classes like <code>.row</code> and <code>.col-xs-4</code> are available for quickly making grid layouts. Less mixins can also be used for more semantic layouts.</li>
    <li>Columns create gutters (gaps between column content) via <code>padding</code>. That padding is offset in rows for the first and last column via negative margin on <code>.row</code>s.</li>
    <li>The negative margin is why the examples below are outdented. It's so that content within grid columns is lined up with non-grid content.</li>
    <li>Grid columns are created by specifying the number of twelve available columns you wish to span. For example, three equal columns would use three <code>.col-xs-4</code>.</li>
    <li>If more than 12 columns are placed within a single row, each group of extra columns will, as one unit, wrap onto a new line.</li>
    <li>Grid classes apply to devices with screen widths greater than or equal to the breakpoint sizes, and override grid classes targeted at smaller devices. Therefore, e.g. applying any <code>.col-md-*</code> class to an element will not only affect its styling on medium devices but also on large devices if a <code>.col-lg-*</code> class is not present.</li>
  </ul>
  <p>Look to the examples for applying these principles to your code.</p>
</div>