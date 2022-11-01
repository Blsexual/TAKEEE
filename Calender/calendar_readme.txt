Calendar documentation

The only file that should be interacted with directly is *calendar_index.php*

For the service to work, a user must always be logged in, otherwise an error is returned.
In the url the user id[8] and token[9] must always be provided for the service to work

uID | The id of the selected user
token | The token that is generated when the user logs in

In the calendar there are a lot of different actions that can be made. Examples will be provided and explained right after

Creating an event | action=createEvent
    calendar_index.php?uID=#&token=#&action=createEvent&title=#&description=#&startDate=#&endDate=#

    title | The title that the event will use | Required input
    description | A description for what the event is | Optional input
    startDate | The date when the event will begin | Required input
    endDate |  End date when the event will end | Required input
#

Edit an event | action=editEvent
    calendar_index.php?uID=#&token=#&action=editEvent&eID=#&title=#&description=#&startDate=#&endDate=#

    eID | The ID of the event that is being edited | Required input
    title | The title that the event will use | Required input
    description | A description for what the event is | Optional input
    startDate | The date when the event will begin | Required input
    endDate |  End date when the event will end | Required input
#

Delete an event | action=deleteEvent
    calendar_index.php?uID=#&token=#&action=deleteEvent&eID=#

    eID | The ID of the event that is being deleted | Required input
#

Show all of the users events and their invitations and events they've accepted | action=showEvent
    calendar_index.php?uID=#&token=#&action=showEvent
#

Show all of the users events and their invitations and events they've accepted and sort them based on a timeline | action=sortTimeline
    calendar_index.php?uID=#&token=#&action=sortTimeline&startDate=#&endDate=#

    startDate | The date when the timeline starts | Required input
    endDate |  The date when the timeline ends | Required input
#

Allows a user to send an ivitation to another user to see a specified event | action=eventInvitation
    calendar_index.php?uID=#&token=#&action=eventInvitation&eID=#&rID=#

    eID | The ID of the event that the recipient is invited to | Required input
    rID | The ID of the recipient that is reciving the invitation| Required input
#

Show all of the users events and their invitations and events they've accepted | action=invitationHandle
    calendar_index.php?uID=#&token=#&action=invitationHandle

#

Show all of the users events and their invitations and events they've accepted | action=invitationLeave
    calendar_index.php?uID=#&token=#&action=invitationLeave

#

Show all of the users events and their invitations and events they've accepted | action=invitationRevoke
    calendar_index.php?uID=#&token=#&action=invitationRevoke
#