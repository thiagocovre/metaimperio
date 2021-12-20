ReadMeMFTF (recommendations for running tests related to Gdpr extension).

    36 Gdpr specific tests, grouped by purpose, for greater convenience.

            This set of tests is recommended to be run at ee2.3.5 magento (strongly recommended).

            Tests group: Gdpr
            Runs all tests.
                SSH command to run this group of tests:
                vendor/bin/mftf run:group Gdpr -r

            Tests group: ConsentCheckbox
                Runs tests related to Consent Checkbox feature.
                SSH command to run this group of tests:
                vendor/bin/mftf run:test ConsentCheckbox -r

            Tests group: ConsentLog
                Runs tests related to Consent Log grid.
                SSH command to run this group of tests:
                vendor/bin/mftf run:test ConsentLog -r

            Tests group: PrivacyPolicy
                Runs tests related to Consent Log grid.
                SSH command to run this group of tests:
                vendor/bin/mftf run:test PrivacyPolicy -r

            Tests group: DeleteRequest
                Runs tests related to delete request by customer.
                SSH command to run this group of tests:
                vendor/bin/mftf run:test DeleteRequest -r

            Tests group: AnonymizeRequest
                Runs tests related to anonymize request by customer.
                SSH command to run this group of tests:
                vendor/bin/mftf run:test AnonymizeRequest -r
