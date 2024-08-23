---
layout: default
title: Optimize the functions in javascript
---

If we have the function:

    function test(a,b){
    	return a + b;
    }

and we launch test(1,2) we will get 3 as a result.
If this function is for example inside a loop which could execute it again with the exact same parameters (i.e. test(1,2)) always obtaining the same result (3), we will have executed a function uselessly because it has already been launched previously, therefore, using computing power for nothing.

While doing:

    var of=new optimizeFunction();
    for(var i=0;i<10;i++)
    	console.log(of.exec("test",[1,2]));
    	
we will always have the result 3 but the function will be executed only once and the value stored, at subsequent uses the value in memory will be shown without re-executing the function.

In case we had the function:

    function test(a,b){
    	return a + b + global_variable;
    }

we will use the object like this:

    of.exec("test", [1, 2], [global_variable]);

Here is the code of optimizeFunction

    function optimizeFunction(){
    	this.memory={};
    	var self=this;
    	this.name_gen=function(ar){
    		return ar[0]+JSON.stringify(ar[1])+JSON.stringify(ar[2]);
    	}
    	this.exec=function(func_name,func_arg,func_arg_external){
    		var name = self.name_gen(arguments);
    		if(typeof self.memory[name] === "undefined"){
    			var args=JSON.stringify(func_arg).replace("[","").replace("]","");
    			self.memory[name] = eval(func_name+'('+args+');');
    		}
    		return self.memory[name];
    	}
    }
