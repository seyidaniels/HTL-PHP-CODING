 10000 users 

 Problem:
• An application for billing 10,000 users over a given billing API (owned by a third
party e.g. Telco/Bank).
• The billing API takes 1.6secs to process and respond to each request
• The details of the users to bill is stored in a Database with fields; id, username,
mobile_number and amount_to_bill 


 Solution 

 #The goal of this script is to be able to make asynchronous calls to the billing API within a particular time 
 If we were to send the request to all 10,000 users, Billing each user is in 1.6 seconds time, we have to wait for a user to be billed without sending the second request. This would take hours and would be very slow 
 PHP is naturally not a multi-threaded programming language, It runs on a single thread, so how do we make async calls to the API end point! assuming this API endpoint has the capability to handle multiple requests at the same time 

 So we make request to bill a user, rather than waiting for the request to be done, we asynchronously execute another request  

 Making use of CURL MULTI function since the requests are not dependent on each otheModel,  so as far as the server can accept concurrent requests at the same time withut casuing it much over-head, we keep executing 

<!- Depending on the amount of resource time the API can handle concurrently, our solution can work in less than 20 minutes for an Ideal System, If the server can handle ten requests at an instance of time, we would be looking at executing 10 requests in one second! We do not have to wait for one to be done before executing the other 

<!- Problems may however arise in the case of the Billing API not able to handle all requests leading to failed Jobs, hence, we write a have a recursive approach that keeps executing when there are 1 or more Failed Jobs 


