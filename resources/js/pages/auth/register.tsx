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

type Props = {
    passwordRules: string;
};

export default function Register({ passwordRules }: Props) {
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
                                    <Label>Sex</Label>

                                    <Select>
                                        <SelectTrigger>
                                            <SelectValue placeholder="Select Sex" />
                                        </SelectTrigger>

                                        <SelectContent>
                                            <SelectItem value="male">
                                                Male
                                            </SelectItem>
                                            <SelectItem value="female">
                                                Female
                                            </SelectItem>
                                        </SelectContent>
                                    </Select>

                                    <InputError message={errors.sex} />
                                </div>
                            </div>

                            {/* Department */}

                            <div className="grid grid-cols-1 gap-4 md:grid-cols-2">
                                {/* Department */}
                                <div className="grid gap-2">
                                    <Label htmlFor="department">
                                        Assigned Department
                                    </Label>

                                    <Select>
                                        <SelectTrigger id="department">
                                            <SelectValue placeholder="Select Department" />
                                        </SelectTrigger>

                                        <SelectContent>
                                            <SelectItem value="cic">
                                                CIC
                                            </SelectItem>
                                            <SelectItem value="registrar">
                                                KTTD
                                            </SelectItem>
                                            <SelectItem value="hr">
                                                SMU
                                            </SelectItem>
                                            <SelectItem value="hr">
                                                MCIIS
                                            </SelectItem>
                                        </SelectContent>
                                    </Select>

                                    <InputError message={errors.department} />
                                </div>

                                {/* Section */}
                                <div className="grid gap-2">
                                    <Label htmlFor="section">Program</Label>

                                    <Select>
                                        <SelectTrigger id="section">
                                            <SelectValue placeholder="Select Section" />
                                        </SelectTrigger>

                                        <SelectContent>
                                            <SelectItem value="bsit4a">
                                                BSCS
                                            </SelectItem>
                                            <SelectItem value="bsit4b">
                                                BSIT-IS
                                            </SelectItem>
                                            <SelectItem value="bsit4b">
                                                BSIT-BTM
                                            </SelectItem>
                                        </SelectContent>
                                    </Select>

                                    <InputError message={errors.section} />
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
