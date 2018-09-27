<?php if(Configuration::showExceptions){ ?><div>{{WHAT}}</div>
<hr/>
<div><?=$ERRMSG?></div>
<hr/>
<div><?="On line $ERRLINE in \"$ERRFILE\""?></div>
<hr/>
<hr/><?php } ?><!--//MLEXCEPTION//--><!--MLEXCEPTION[<?=$ERRLINE . "@" . $ERRFILE . " - " . str_replace("]",")",str_replace("[","(",$ERRMSG))?>]-->