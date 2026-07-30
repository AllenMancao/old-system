import { Form, Head } from '@inertiajs/react';
import InputError from '@/components/input-error';
import PasswordInput from '@/components/password-input';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { login } from '@/routes';
import { store } from '@/routes/register';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';

type Department = {
    id: number;
    name: string;
};
type Course = {
    id: number;
    course_code: string;
};
type Props = {
    passwordRules: string;
    departments: Department[];
    courses: Course[];
};

export default function Register({ passwordRules, departments, courses }: Props) {
    return (
        <>
            <Head title="Register" />
            <Form
                {...store.form()}
                resetOnSuccess={['password', 'password_confirmation']}
                disableWhileProcessing
                className="flex flex-col gap-6"
            >
                {({ processing, errors }) => (
                    <>
                        <div className="grid gap-6">
                            {/* Name + Contact */}
                            <div className="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div className="grid gap-2">
                                    <Label htmlFor="name">Full Name</Label>
                                    <Input
                                        id="name"
                                        name="name"
                                        placeholder="Juan Dela Cruz"
                                        required
                                        autoFocus
                                    />
                                    <InputError message={errors.name} />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="contact_number">
                                        Contact Number
                                    </Label>
                                    <Input
                                        id="contact_number"
                                        name="contact_number"
                                        placeholder="09XXXXXXXXX"
                                    />
                                    <InputError
                                        message={errors.contact_number}
                                    />
                                </div>
                            </div>
                            <div className="grid gap-2">
    <Label htmlFor="student_number">Student Number</Label>
    <Input
        id="student_number"
        name="student_number"
        placeholder="2021-00123"
        required
    />
    <InputError message={errors.student_number} />
</div>

                            {/* Email + Sex */}

                            <div className="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div className="grid gap-2">
                                    <Label htmlFor="email">Email Address</Label>
                                    <Input
                                        id="email"
                                        type="email"
                                        name="email"
                                        placeholder="intern@usep.edu.ph"
                                        required
                                    />
                                    <InputError message={errors.email} />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="sex">Sex</Label>

                                    <select
                                        id="sex"
                                        name="sex"
                                        required
                                        className="h-10 rounded-md border border-input bg-background px-3 py-2 text-sm"
                                    >
                                        <option value="">Select Sex</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>

                                    <InputError message={errors.sex} />
                                </div>
                            </div>

                            {/* Department */}

                            <div className="grid grid-cols-1 gap-4 md:grid-cols-2">
                                {/* Department */}
                                <div className="grid gap-2">
                                    <Label htmlFor="department_id">
                                        Assigned Department
                                    </Label>

                                    <select
                                        id="department_id"
                                        name="department_id"
                                        required
                                        className="h-10 rounded-md border border-input bg-background px-3 py-2 text-sm"
                                    >
                                        <option value="">
                                            Select Department
                                        </option>

                                        {departments.map((department) => (
                                            <option
                                                key={department.id}
                                                value={department.id}
                                            >
                                                {department.name}
                                            </option>
                                        ))}
                                    </select>

                                    <InputError
                                        message={errors.department_id}
                                    />
                                </div>

                                {/* Course */}
<div className="grid gap-2">
    <Label htmlFor="course_id">Course / Program</Label>

    <select
        id="course_id"
        name="course_id"
        required
        className="h-10 rounded-md border border-input bg-background px-3 py-2 text-sm"
    >
        <option value="">Select Course</option>
        {courses.map((course) => (
            <option key={course.id} value={course.id}>
                {course.course_code}
            </option>
        ))}
    </select>

    <InputError message={errors.course_id} />
</div>
                            </div>

                            {/* Passwords */}

                            <div className="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div className="grid gap-2">
                                    <Label htmlFor="password">Password</Label>

                                    <PasswordInput
                                        id="password"
                                        name="password"
                                        placeholder="Password"
                                        passwordrules={passwordRules}
                                        required
                                    />

                                    <InputError message={errors.password} />
                                </div>

                                <div className="grid gap-2">
                                    <Label htmlFor="password_confirmation">
                                        Confirm Password
                                    </Label>

                                    <PasswordInput
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        placeholder="Confirm Password"
                                        passwordrules={passwordRules}
                                        required
                                    />

                                    <InputError
                                        message={errors.password_confirmation}
                                    />
                                </div>
                            </div>

                            <Button type="submit" className="w-full">
                                {processing && <Spinner />}
                                Create Account
                            </Button>
                        </div>

                        <div className="text-center text-sm text-muted-foreground">
                            Already have an account?{' '}
                            <TextLink href={login()} tabIndex={6}>
                                Log in
                            </TextLink>
                        </div>
                    </>
                )}
            </Form>
        </>
    );
}

Register.layout = {
    title: 'Create an account',
    description: 'Enter your details below to create your account',
};
