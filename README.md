

<table align="center">
  <tr>
    <th>Entire assignment is repost from my other profile</th>
  </tr>
</table>


# WEBTE2 2. Assignment SS 2022/2023

This is an assignment for the WEBTE2 course for the academic year 2022/2023.

## General Instructions
- The tasks should be optimized for the latest versions of Google Chrome and Firefox.
- Assignments are always due at midnight on the day before the class.
- Late submission of assignments will result in a reduction of points.
- Create a new database for each assignment unless stated otherwise.
- Submit the assignment as a zip file, including the parent directory. Use the naming convention `idStudent_lastname.zip`.
- The zip archive should contain the following files:
  - `index.php` (main script)
  - `config.php` (configuration file placed in the same directory as `index.php`)
  - `idStudent_lastname.sql` (database dump, if applicable)
  - `idStudent_lastname.doc` (technical report, if submitted)
- Include a note with the link to the functional assignment hosted on your assigned server (`siteXX.webte.fei.stuba.sk`).

Example structure of the submitted assignment: 12345_mrkvicka_z2.zip:
12345_mrkvicka_z2/
- index.php
- config.php
- 12345_mrkvicka_z2.sql (in case of working with a database)
- 12345_mrkvicka_z2.doc (only for technical report)

When submitting the assignment through MS Teams, make sure to include the technical report and include the URL of your page on the school server in the note.

## Assignment Description
The assignment focuses on retrieving data from external sources using CURL and creating an API to provide access to the retrieved data.

Create a web application that allows tracking the lunch menus offered by restaurants near our faculty. Only restaurants that can be reached on foot from the school for lunch should be considered.

The application should consist of three subpages:
1. Displaying the lunch menu
2. Description of the created API methods
3. Verification of the created API methods

1. Find three different lunch service providers near the school who offer lunch menus. Select providers whose menus can be programmatically parsed.

2. On the verification page for the created API methods, place three buttons: "Download," "Parse," and "Delete."

3. When the "Download" button is pressed, use CURL to download the current menus from each restaurant's website, and store the obtained data in a database along with the date of download.

4. When the "Parse" button is pressed, take the last record from the previous step, parse the downloaded data, and store the parsed data in the database. Avoid storing duplicate data. The required information to extract and store includes:
   - Menu items
   - Price of each item (if available)
   - Location where the item can be purchased
   - Validity date of the menu
   - Download and store any available images related to the menu items.

5. When the "Delete" button is pressed, delete the tables in the database that store all the information related to the lunch menus, both parsed and unparsed (at least two tables).

6. Create an API to provide web services related to the lunch menus near the faculty. The API methods should allow:
   - Retrieving a list of menu items with their respective prices for the current week from all restaurants
   - Retrieving JSON data with detailed information about the items available on a specific day (including price and location)
   - Modifying the price of a specific menu item
   - Deleting the menu of a selected restaurant from the database, along with all related data
   - Adding a new menu item to a restaurant's menu for the entire current week (e.g., a special dish not included in the standard menu)

   Create the web service API using one of the following alternatives: XML-RPC, JSON-RPC, SOAP, or REST. Make sure to demonstrate the usage of the chosen web service approach in your implementation. If using REST, adhere to REST principles.

7. Properly handle errors and send appropriate error statuses (e.g., 400, 500).

8. On a designated subpage, provide documentation for the created API. If you choose to create a WSDL document for SOAP, visualize the API methods using a freely available WSDL viewer. Alternatively, you can manually describe the API. For documenting the API, you can also use a library that allows testing individual endpoints.

9. Based on the created API, create a web page that displays the lunch menu for the current week in a clear and organized manner (don't forget to include dates). Include all the information from step 4 of this assignment.

   Note: The page should not display the lunch menu for each restaurant separately. It should be combined to allow users to easily compare the menus and decide where to go for lunch. Design the layout of the page to accommodate additional restaurants in the future.

10. Allow displaying the lunch menu not only for the entire week but also for a selected day.

11. To test all the created API methods, create a client-side application that allows entering input data through a form.

## Conclusion
This assignment focuses on retrieving data from external sources using CURL, creating an API, and displaying the lunch menus for nearby restaurants. Follow the instructions provided and make sure to implement the required functionalities. Good luck with your assignment!
