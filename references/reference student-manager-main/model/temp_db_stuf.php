    <form action="." method="post">
        <input type="hidden" name="action" value="make_student">
        <input type="text" name="studentFN" value="John" required>
        <input type="text" name="studentLN" value="Smith" required>
        <input type="date" name="dob" required>
        <input type="email" name="email" required>
        <input type="submit" name="createDB" value="Create Student">
    </form>

    <form action="." method="post">
        <input type="hidden" name="action" value="remove_student">
        <input type="submit" name="delStdnt" value="Remove Student">
    </form>