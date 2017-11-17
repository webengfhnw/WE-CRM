<?php
/**
 * Created by PhpStorm.
 * User: andreas.martin
 * Date: 05.11.2017
 * Time: 17:27
 * Based on: https://gist.github.com/henriquemoody/6580488
 */

namespace http;


interface HTTPStatusCode
{
    const HTTP_100_CONTINUE = "Continue";
    const HTTP_101_SWITCHING_PROTOCOLS = "Switching Protocols";
    const HTTP_102_PROCESSING = "Processing"; // WebDAV; RFC 2518
    const HTTP_200_OK = "OK";
    const HTTP_201_CREATED = "Created";
    const HTTP_202_ACCEPTED = "Accepted";
    const HTTP_203_NON_AUTHORITATIVE_INFORMATION = "Non_Authoritative Information"; // since HTTP/1.1
    const HTTP_204_NO_CONTENT = "No Content";
    const HTTP_205_RESET_CONTENT = "Reset Content";
    const HTTP_206_PARTIAL_CONTENT = "Partial Content";
    const HTTP_207_MULTI_STATUS = "Multi_Status"; // WebDAV; RFC 4918
    const HTTP_208_ALREADY_REPORTED = "Already Reported"; // WebDAV; RFC 5842
    const HTTP_226_IM_USED = "IM Used"; // RFC 3229
    const HTTP_300_MULTIPLE_CHOICES = "Multiple Choices";
    const HTTP_301_MOVED_PERMANENTLY = "Moved Permanently";
    const HTTP_302_FOUND = "Found";
    const HTTP_303_SEE_OTHER = "See Other"; // since HTTP/1.1
    const HTTP_304_NOT_MODIFIED = "Not Modified";
    const HTTP_305_USE_PROXY = "Use Proxy"; // since HTTP/1.1
    const HTTP_306_SWITCH_PROXY = "Switch Proxy";
    const HTTP_307_TEMPORARY_REDIRECT = "Temporary Redirect"; // since HTTP/1.1
    const HTTP_308_PERMANENT_REDIRECT = "Permanent Redirect"; // approved as experimental RFC
    const HTTP_400_BAD_REQUEST = "Bad Request";
    const HTTP_401_UNAUTHORIZED = "Unauthorized";
    const HTTP_402_PAYMENT_REQUIRED = "Payment Required";
    const HTTP_403_FORBIDDEN = "Forbidden";
    const HTTP_404_NOT_FOUND = "Not Found";
    const HTTP_405_METHOD_NOT_ALLOWED = "Method Not Allowed";
    const HTTP_406_NOT_ACCEPTABLE = "Not Acceptable";
    const HTTP_407_PROXY_AUTHENTICATION_REQUIRED = "Proxy Authentication Required";
    const HTTP_408_REQUEST_TIMEOUT = "Request Timeout";
    const HTTP_409_CONFLICT = "Conflict";
    const HTTP_410_GONE = "Gone";
    const HTTP_411_LENGTH_REQUIRED = "Length Required";
    const HTTP_412_PRECONDITION_FAILED = "Precondition Failed";
    const HTTP_413_REQUEST_ENTITY_TOO_LARGE = "Request Entity Too Large";
    const HTTP_414_REQUEST_URI_TOO_LONG = "Request_URI Too Long";
    const HTTP_415_UNSUPPORTED_MEDIA_TYPE = "Unsupported Media Type";
    const HTTP_416_REQUESTED_RANGE_NOT_SATISFIABLE = "Requested Range Not Satisfiable";
    const HTTP_417_EXPECTATION_FAILED = "Expectation Failed";
    const HTTP_418_IM_A_TEAPOT = "I\'m a teapot"; // RFC 2324
    const HTTP_419_AUTHENTICATION_TIMEOUT = "Authentication Timeout"; // not in RFC 2616
    const HTTP_420_METHOD_FAILURE = "Method Failure"; // Spring Framework
    const HTTP_420_ENHANCE_YOUR_CALM = "Enhance Your Calm"; // Twitter
    const HTTP_422_UNPROCESSABLE_ENTITY = "Unprocessable Entity"; // WebDAV; RFC 4918
    const HTTP_423_LOCKED = "Locked"; // WebDAV; RFC 4918
    const HTTP_424_FAILED_DEPENDENCY = "Failed Dependency"; // WebDAV; RFC 4918
    const HTTP_424_METHOD_FAILURE = "Method Failure"; // WebDAV)
    const HTTP_425_UNORDERED_COLLECTION = "Unordered Collection"; // Internet draft
    const HTTP_426_UPGRADE_REQUIRED = "Upgrade Required"; // RFC 2817
    const HTTP_428_PRECONDITION_REQUIRED = "Precondition Required"; // RFC 6585
    const HTTP_429_TOO_MANY_REQUESTS = "Too Many Requests"; // RFC 6585
    const HTTP_431_REQUEST_HEADER_FIELDS_TOO_LARGE = "Request Header Fields Too Large"; // RFC 6585
    const HTTP_444_NO_RESPONSE = "No Response"; // Nginx
    const HTTP_449_RETRY_WITH = "Retry With"; // Microsoft
    const HTTP_450_BLOCKED_BY_WINDOWS_PARENTAL_CONTROLS = "Blocked by Windows Parental Controls"; // Microsoft
    const HTTP_451_UNAVAILABLE_FOR_LEGAL_REASONS = "Unavailable For Legal Reasons"; // Internet draft
    const HTTP_451_REDIRECT = "Redirect"; // Microsoft
    const HTTP_494_REQUEST_HEADER_TOO_LARGE = "Request Header Too Large"; // Nginx
    const HTTP_495_CERT_ERROR = "Cert Error"; // Nginx
    const HTTP_496_NO_CERT = "No Cert"; // Nginx
    const HTTP_497_HTTP_TO_HTTPS = "HTTP to HTTPS"; // Nginx
    const HTTP_499_CLIENT_CLOSED_REQUEST = "Client Closed Request"; // Nginx
    const HTTP_500_INTERNAL_SERVER_ERROR = "Internal Server Error";
    const HTTP_501_NOT_IMPLEMENTED = "Not Implemented";
    const HTTP_502_BAD_GATEWAY = "Bad Gateway";
    const HTTP_503_SERVICE_UNAVAILABLE = "Service Unavailable";
    const HTTP_504_GATEWAY_TIMEOUT = "Gateway Timeout";
    const HTTP_505_HTTP_VERSION_NOT_SUPPORTED = "HTTP Version Not Supported";
    const HTTP_506_VARIANT_ALSO_NEGOTIATES = "Variant Also Negotiates"; // RFC 2295
    const HTTP_507_INSUFFICIENT_STORAGE = "Insufficient Storage"; // WebDAV; RFC 4918
    const HTTP_508_LOOP_DETECTED = "Loop Detected"; // WebDAV; RFC 5842
    const HTTP_509_BANDWIDTH_LIMIT_EXCEEDED = "Bandwidth Limit Exceeded"; // Apache bw/limited extension
    const HTTP_510_NOT_EXTENDED = "Not Extended"; // RFC 2774
    const HTTP_511_NETWORK_AUTHENTICATION_REQUIRED = "Network Authentication Required"; // RFC 6585
    const HTTP_598_NETWORK_READ_TIMEOUT_ERROR = "Network read timeout error"; // Unknown
    const HTTP_599_NETWORK_CONNECT_TIMEOUT_ERROR = "Network connect timeout error"; // Unknown
}