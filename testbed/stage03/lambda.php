<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 09.10.2017
 * Time: 08:51
 */

// Regular function
function helloRegularFunction()
{
    return "Say hello to my regular function\r\n";
}

echo helloRegularFunction(); // Returns "Say hello to my regular function"

// Anonymous function
function ()
{
    return "Say hello to my anonymous function\r\n";
};

// Lambda function (anonymous function, which is assigned to a variable)
$helloLambdaFunction = function () {
    return "Say hello to my Lambda function\r\n";
};

// Call Lambda function
echo $helloLambdaFunction(); // Returns "Say hello to my Lambda function"

// Passing Lambda to a function, which is known as a callback.
function regularFunctionCallback($callbackFunction)
{
    echo $callbackFunction(); //Call the callback
}

// Call regular function and passing a Lambda function
regularFunctionCallback($helloLambdaFunction); // Returns "Say hello to my Lambda function"

// Call regular function and passing an anonymous function
regularFunctionCallback(function () {
    return "Say hello to my anonymous function\r\n";
}); // Returns "Say hello to my anonymous function"

// Lambda function (anonymous function, which is assigned to a variable) with two parameters
$helloLambdaFunctionParameter = function ($param1, $param2) {
    return "Say hello to my Lambda function with ". $param1 . " and " . $param2 . "\r\n";
};// Returns "Say hello to my Lambda function with param one and param two"

// Call Lambda function with the two parameters
echo $helloLambdaFunctionParameter("param one","param two"); // Returns "Say hello to my Lambda function with param one and param two"

// Passing Lambda and an array containing parameters to a function, and call it with the parameter array
function regularFunctionCallbackArray($callbackFunction, $param_array)
{
    echo $callbackFunction(...$param_array); //Call the callback and passing the parameters by using ... for variable arguments PHP 5.6+
}

// Call regular function and passing a Lambda function with a parameter array
regularFunctionCallbackArray($helloLambdaFunctionParameter, array("param one","param two")); // Returns "Say hello to my Lambda function with param one and param two"